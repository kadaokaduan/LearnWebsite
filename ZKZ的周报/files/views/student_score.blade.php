<table>
<?php
	foreach($arr as $e){
		echo '<tr>';
		$attributes = ['course_name', 'total_score'];
		foreach($attributes as $attribute){
			echo '<td>';
			echo $e[$attribute];
			echo '</td>';
		}
		echo '</tr>';
	}
?>
</table>