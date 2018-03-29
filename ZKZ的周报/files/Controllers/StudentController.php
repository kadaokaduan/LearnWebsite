<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use thiagoalessio\TesseractOCR\TesseractOCR;

class StudentController extends Controller
{
	function index(){
		return view('student_login');
	}
	
	function login(){
		$cookieFile = __DIR__.'/cookie.tmp'; 
		$captchaImg = 'captcha.jpg';
		$maxTryCount = 1000;
		/* 获取用户输入的数据 */
		$j_username = $_REQUEST['j_username'];
		$j_password = $_REQUEST['j_password'];
		if(!$j_username || !$j_password){
			echo '请输入用户名和密码！';
			return;
		}
		if(1){
			/* 循环尝试获取并识别验证码直到成功为止 */
			$success = false;
			$tryCount = 0;
			while(!$success && $tryCount < $maxTryCount){
				++$tryCount;
				/* 获取验证码 */
				$ch = curl_init('http://jw.cuc.edu.cn/academic/getCaptcha.do');
				curl_setopt($ch, CURLOPT_COOKIEJAR, $cookieFile);
				curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
				$content = curl_exec($ch);
				file_put_contents($captchaImg, $content);
				curl_close($ch);
				/* 识别验证码 */
				$captchaCode = (new TesseractOCR($captchaImg))->whitelist(range(0, 9))->run();
				/* 构造目标url */
				$url = 'http://jw.cuc.edu.cn/academic/j_acegi_security_check?';
				$postData = array(
					'groupid' => '',
					'j_username' => $j_username,
					'j_password' => $j_password,
					'j_captcha' => $captchaCode,
					'login' => '登录'
					);
				foreach($postData as $k => $v){
					$url = $url.$k.'='.$v.'&';
				}
				/* 尝试登录 */
				$ch = curl_init($url);
				curl_setopt($ch, CURLOPT_REFERER, 'http://jw.cuc.edu.cn/home/index.do');
				curl_setopt($ch, CURLOPT_AUTOREFERER, 1);
				curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
				curl_setopt($ch, CURLOPT_COOKIEFILE, $cookieFile);
				curl_setopt($ch, CURLOPT_COOKIEJAR, $cookieFile);
				curl_setopt($ch, CURLOPT_HEADER, 1);
				curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
				$content = curl_exec($ch);
				curl_close($ch);
				/* 判断是否成功并更新 */
				$success = strpos($content,'Set-Cookie');
			}/* end while */
			if(!$success){
				echo '登录超时，可能是用户名或密码错误所导致。请返回并重新尝试。';
				return;
			}
			/* 登录成功以后获取成绩查询页 */
			$url = 'http://jw.cuc.edu.cn/academic/manager/score/studentOwnScore.do?';
			$postData =array(
				"year" => "",
				"term" => "",
				"prop" => "",
				"para" => "0",
				"sortColumn" => "",
				"Submit" => "查询");
			foreach($postData as $k => $v){
				$url = $url.$k.'='.$v.'&';
			}
			$ch = curl_init($url);
			curl_setopt($ch, CURLOPT_COOKIEFILE, $cookieFile);
			curl_setopt($ch, CURLOPT_REFERER, 'http://jw.cuc.edu.cn/academic/manager/score/studentOwnScore.do');
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
			header('Content-Type: text/html;charset=utf-8');
			$content = curl_exec($ch);
			curl_close($ch);
			/* 坑。需转码，否则乱码。
			详见 https://towait.com/blog/php-domdocument-loadhtml-not-encoding-utf-8-correctly/ */
			$content = mb_convert_encoding($content, 'HTML-ENTITIES', 'UTF-8');
			/* 处理页面内容 */
			$dom = new \DOMDocument();
			$dom->loadHTML($content);
			$xpath = new \DOMXPath($dom);
			$trs = $xpath->evaluate('//tr');
			/*
			[0] => 学年		[1] => 学期		[2] => 开课院系	[3] => 课程号
			[4] => 课程名	[5] => 课序号	[6] => 平时		[7] => 期中
			[8] => 期末		[9] => 实验		[10] => 口试	[11] => 总评
			[12] => 绩点	[13] => 学分	[14] => 学时	[15] => 考核方式
			[16] => 选课属性[17] => 备注	[18] => 考试性质[19] => 二学位/辅修
			[20] => 课程性质[21] => 及格标志
			*/
			$lines = [];
			$skip_first = false;
			foreach($trs as $tr){
				if(!$skip_first){
					$skip_first = true;
					continue;
				}
				$line = [];
				for($i=0;$i<=43;$i+=2){
					$node = $tr->childNodes[$i];
					$value = trim($node->nodeValue);
					$line[] = $value;
				}
				$lines[] = $line;
			}
			$lines = array_slice($lines, 1);
			foreach($lines as $line){
			/* 提取Course信息并保存（如果数据库中没有的话） */
			{
				$course_attributes = Array(
					'academy' => 		$line[2],
					'course_number' => 	$line[3],
					'course_id' => 		$line[5] + 0,
					'course_name' => 	$line[4],
					'credits' => 		$line[13] + 0.,
					'period' => 		$line[14] + 0,
					'type' => 			$line[16],
				);
				$course = \App\Course::
					where('course_number', '=', $course_attributes['course_number'])-> 
					where('course_id', '=', $course_attributes['course_id'])-> 
					get()->toArray();
				if($course){
					/* 课程已存在 */
					/* 如果已存在，暂时先不做任何事情 */;
				}
				else{
					/* 课程不存在 */
					/* 构造课程并保存 */
					$course = new \App\Course;
					foreach($course_attributes as $k => $v){
						$course->$k = $v;
					}
					$course->save();
				}
			}
			/* 提取Score信息并保存（如果数据库中没有的话） */
			{
				$score_attributes = Array(
					'year' =>	$line[0],
					'term' =>	$line[1],
					'student_number' =>	$j_username,
					'course_number' => $line[3],
					'course_id' => $line[5] + 0,
					'class_performance' => $line[6] + 0.,
					'middle_exam' => $line[7]+0.,
					'final_exam' => $line[8]+0.,
					'total_score' => $line[11] == '优' ? 100 : $line[11]+0.,
					'gpa' => $line[12] + 0.,
					'passed' => $line[21] == '及格' ? true : false
				);
				$score = \App\Score::
					where('student_number', '=', $score_attributes['student_number'])->
					where('course_number', '=', $course_attributes['course_number'])-> 
					where('course_id', '=', $course_attributes['course_id'])-> 
					get()->toArray();
				if($score){
					/* 成绩已存在 */
					/* 如果已存在，暂时先不做任何事情 */;
				}
				else{
					/* 成绩不存在 */
					/* 构造成绩并保存 */
					$score = new \App\Score;
					foreach($score_attributes as $k => $v){
						$score->$k = $v;
					}
					$score->save();
				}
			}
		}
		}/* 入库完成，提取所需数据传给视图文件 */
		$arr = \App\Score::join('courses', function($join){
				$join->on('scores.course_number', '=', 'courses.course_number')
					->on('scores.course_id', '=', 'courses.course_id');
			})->
			select(['course_name', 'total_score'])->
			where('student_number', '=', $j_username)->
			get()->toArray();
		return view('student_score')->with('arr', $arr);
	}
}