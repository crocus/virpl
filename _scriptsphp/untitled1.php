<?php
	//----------------------------------
	// Pages
	//----------------------------------
	if ($number){
		$total_pages = @ceil($count_all / $number);
		$current_page = ($start_from/$number) + 1;
		$pages = '';

		//Advanced pagination
		if ($total_pages > 10){
			//Left block
			$pages_start = 1;
			$pages_max = $current_page >= 5 ? 3 : 5;
			for($j = $pages_start; $j <= $pages_max; $j++){
				if($j == $current_page){
					$pages .= '<b>'.$j.' </b>';
				} else {
					$pages .= '<a href="'.$PHP_SELF.'?start_from='.(($j - 1) * $number).'&ucat='.$ucat.
					'&archive='.$url_archive.'&subaction='.$subaction.'&id='.$id.'&'.$user_query.'">'.$j.' </a>';
				}
			}
			$pages .= '... ';

			//Middle block
			if($current_page > 4 && $current_page < ($total_pages - 3)){
				$pages_start = $current_page - 1;
				$pages_max = $current_page + 1;
				for($j = $pages_start; $j <= $pages_max; $j++){
					if($j == $current_page){
						$pages .= '<b>'.$j.' </b>';
					} else {
						$pages .= '<a href="'.$PHP_SELF.'?start_from='.(($j - 1) * $number).'&ucat='.$ucat.
						'&archive='.$url_archive.'&subaction='.$subaction.'&id='.$id.'&'.$user_query.'">'.$j.' </a>';
					}
				}
				$pages .= '... ';
			}

			//Right block
			$pages_start = $current_page <= $total_pages - 4 ? $total_pages - 2 : $total_pages - 4;
			$pages_max = $total_pages;
			for($j = $pages_start; $j <= $pages_max; $j++){
				if($j == $current_page){
					$pages .= '<b>'.$j.' </b>';
				}
				else{
					$pages .= '<a href="'.$PHP_SELF.'?start_from='.(($j - 1) * $number).'&ucat='.$ucat.
					'&archive='.$url_archive.'&subaction='.$subaction.'&id='.$id.'&'.$user_query.'">'.$j.' </a>';
				}
			}
		}

		//Normal pagination
		else {
			for ($j = 1; $j <= $total_pages; $j++){
				if ((($j - 1) * $number) != $start_from){
					$pages .= '<a href="'.$PHP_SELF.'?start_from='.(($j - 1) * $number).'&ucat='.$ucat.
					'&archive='.$url_archive.'&subaction='.$subaction.'&id='.$id.'&'.$user_query.'">'.$j.' </a> ';
				} else {
					$pages .= ' <b>'.$j.'</b> ';
				}
			}
		}

		$prev_next_msg = str_replace('{pages}', $pages, $prev_next_msg);
	}
?>