<?php

    function buildAttr($attr, $val = null){
        if(is_array($attr) && !empty(array_filter($attr))) {
            $attrs = $attr;
            $builtAttrs = array();

            foreach ($attrs as $key => $val) {
                if(is_array($val)) $val = join(' ', array_filter($val, 'strlen'));
                if(empty($val)) continue;

                $builtAttrs[] = $key.'="'.$val.'"';
            }

            return join(' ', array_filter($builtAttrs, 'strlen'));

        } else {
            if(is_array($val)) $val = join(' ', array_filter($val,'strlen'));
            if(empty($val)) return;

            return $attr. '="' . $val . '"';
        }
    }

	function handleize($string) {
		//Lower case everything
		$string = strtolower($string);
		//Make alphanumeric (removes all other characters)
		$string = preg_replace("/[^a-z0-9_\s-]/", "", $string);
		//Clean up multiple dashes or whitespaces
		$string = preg_replace("/[\s-]+/", " ", $string);
		//Convert whitespaces and underscore to dash
		$string = preg_replace("/[\s_]/", "-", $string);
		return $string;
	}

    function limit($content, $limit = 25) {
        if(empty($content)) return;

        $excerpt = explode(' ', $content, $limit);

        if (count($excerpt) >= $limit) {
            array_pop($excerpt);
            $excerpt = implode(" ", $excerpt) . '...';
        } else {
            $excerpt = implode(" ", $excerpt);
        }

        $excerpt = preg_replace('`\[[^\]]*\]`', '', $excerpt);

        return $excerpt;
    }

    function excerpt($id = 1, $limit=50) {
		$id = $id === 1 ? get_the_ID() : $id;

        return limit(get_the_excerpt($id), $limit);
	}

    function create_excerpt($text, $excerpt_length = 100) {
        $trimmed_text = wp_trim_words($text, $excerpt_length, '');
        $excerpt = substr($trimmed_text, 0, $excerpt_length);
        
        if (strlen($trimmed_text) > $excerpt_length) {
            $excerpt .= '...';
        }
        
        return $excerpt;
    }

	function getFile($path) {
		if (is_file($path)) {
			ob_start();
			include $path;
			return ob_get_clean();
		}
		return false;
	}

	function getSVG($name, $title = false, $icon = true){
		$svgPath = get_template_directory() . '/dist/svgs/';
		$svg = getFile($svgPath.$name.'.svg');

		if($svg){
			// title arg exists and the svg has a title tag to replace
			if( !empty($title) && preg_match("/<title>(.+)<\/title>/i", $svg, $matches)) {
				$title = '<title>'.$title.'</title>';
				$svg = preg_replace("/<title>(.+)<\/title>/i", $title, $svg);
            }

            $svgType = $icon ? 'icon' : 'code';

            $html = '<div class="svg-'.$svgType.' svg-'.$svgType.'--'.$name.'">';
            $html .= !$icon ? $svg : '<div class="positioner">'.$svg.'</div>';
            $html .= '</div>';

            return $html;
		}

		return false;
	}

    function getSocialLinks($socials = null){
        if(is_null($socials)) $socials = get_field('global', 'option')['contact']['socials'];

        if(!empty($socials)) {
            $html = '<nav class="social-links"><ul>';

            foreach($socials as $link){
                $icon = strtolower($link['icon']);
                $url = $link['url'];

                if($icon == 'other') $icon = 'world';

                $html .= '<li><a href="'.$url.'" target="_blank">';
                $html .= getSVG($icon);
                $html .= '</a></li>';
            }

            $html .= '</ul></nav>';
            return $html;
        }
        return false;
    }

    function getShareLinks(){
        $page_url = esc_url('https:'.get_the_permalink());
        $page_img = get_the_post_thumbnail_url( );
        $page_title = get_the_title();

        $shareLinks = array(
            'facebook' => 'https://www.facebook.com/sharer/sharer.php?u='.$page_url,
            'twitter' => 'https://twitter.com/intent/tweet?url='.$page_url.'&text='.$page_title,
            'linkedin' => 'https://www.linkedin.com/shareArticle?mini=true&url='.$page_url.'&title='.$page_title.'&summary='.$page_title.'%0A'.$page_url,
            'pinterest' => 'https://www.pinterest.com/pin/create/button/?url='.$page_url.'&media='.$page_img.'&description='.$page_title.'%0A'.$page_url,
            'email' => 'mailto:?subject='.$page_title.'&body='.$page_title.'%0A'.$page_url
        );

        $html = '<div class="sharelinks">';
        $html .= '<span class="sharelinks__label">Share '.getSVG('download').'</span>';
        $html .= '<div class="sharelinks__list"><ul>';

        foreach($shareLinks as $social => $link):
            $html .= '<li>';
            $html .= '<a class="sharelinks__link sharelinks__link--'.$social.'" href="'.$link.'" target="_blank">'.getSVG($social).'</a>';
            $html .= '</li>';
        endforeach;

        $html .= '</ul"></div>';
        $html .= '</div>';

        echo $html;
    }



    function readTime($content){
        $word_count = str_word_count( strip_tags( $content ) );
        $readingtime = ceil($word_count / 250);
    
        // Determine the correct plural form of "min"
        $timer = ($readingtime == 1) ? " min read" : " mins read";
        $totalreadingtime = $readingtime . $timer;
    
        if( $readingtime != 0 ){
            return $totalreadingtime;
        }
    }

    function get_small_excerpt($content, $length = 100)
    {
        // Strip HTML tags and trim whitespace
        $content = wp_strip_all_tags($content);
        $content = trim($content);

        // Get the first $length characters as the excerpt
        $excerpt = substr($content, 0, $length);

        // Append "..." if the content is longer than the excerpt
        if (strlen($content) > $length) {
            $excerpt .= '...';
        }

        return $excerpt;
    }

    // Helper function to extract the YouTube video ID from the URL
    function getYouTubeVideoID($url) {
        parse_str(parse_url($url, PHP_URL_QUERY), $query_params);
        if (isset($query_params['v'])) {
            return $query_params['v'];
        } else {
            return false;
        }
    }

    // Function to extract the video ID from the URL
    function get_youtube_video_id($url) {
        $video_id = '';
        $parsed_url = parse_url($url);
        if (isset($parsed_url['query'])) {
            parse_str($parsed_url['query'], $query_params);
            if (isset($query_params['v'])) {
                $video_id = $query_params['v'];
            }
        }
        return $video_id;
    }

