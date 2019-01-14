<?php

# YouTube PHP class
# used for embedding videos as well as video screenies on web page without single line of HTML code
#
# Dedicated to my beloved brother FILIP. Rest in peace!
#
# by Avram, www.avramovic.info

class YouTube {

	private $id = NULL;

	/**
	 * Constructor
	 *
	 * This is the default constructor which accepts YouTube URL in any of most commonly used forms.
	 *
	 * @access protected
	 * @param string $url YouTube URL in any of most commonly used forms. Can be ommited (defaults to null),
	 *  but you will have to use setID to set ID explicitly
	 * @see setID
	 */

	function __construct($url = null)
	{
		if ($url != null)
		{
			$this->id = YouTube::parseURL($url);
		}
	}

	/**
	 * Set YouTube ID explicitly
	 *
	 * This method sets YouTube ID explicitly. It checks if the ID is in good format. If yes it will set it
	 * and return true, and if not - it will return false
	 *
	 * @access public
	 * @param string $id YouTube ID
	 * @return boolean Whether the ID has been set successfully
	 */

	public function setID($id)
	{
		if (preg_match('/([A-Za-z0-9_-]+)/', $url, $matches))
		{
			$this->id = $id;
			return true;
		}
		else
			return false;
	}

	/**
	 * Get string representation of YouTube ID
	 *
	 * This method returns YouTube video ID if any. Otherwise returns null.
	 *
	 * @access public
	 * @return string YouTube video ID if any, otherwise null
	 */

	public function getID()
	{
		return $this->id;
	}

	/**
	 * Parse YouTube URL and return video ID.
	 *
	 * This method sreturnns YouTube video ID if any. Otherwise returns null.
	 *
	 * @access public
	 * @static
	 * @param string $url URL of YouTube video in any of most commonly used forms
	 * @return string YouTube video ID if any, otherwise null
	 */

	public static function parseURL($url)
	{
		if (preg_match('/watch\?v\=([A-Za-z0-9_-]+)/', $url, $matches))
			return $matches[1];
		else
			return false;
	}

	/**
	 * Get YouTube video HTML embed code
	 *
	 * This method returns HTML code which is used to embed YouTube video in page
	 *
	 * @access public
	 * @param string $url YouTube video URL. If this cannot be parsed it will be used as video ID. It can be omitted
	 * @param integer $width Width of embedded video, in pixels. Defaults to 425
	 * @param integer $height Height of embedded video, in pixels. Defaults to 344
	 * @return string HTML code which is used to embed YouTube video in page
	 */

	public function EmbedVideo($url = null, $width = 425, $height = 344) {
		if ($url == null)
			$videoid = $this->id;
		else
		{
			$videoid = YouTube::parseURL($url);
			if (!$videoid) $videoid = $url;
		}

		return '<object width="'.$width.'" height="'.$height.'"><param name="movie" value="http://www.youtube.com/v/'.$videoid.'?rel=0&fs=1&loop=0"></param><param name="wmode" value="transparent"></param><param name="allowFullScreen" value="true"><embed src="http://www.youtube.com/v/'.$videoid.'?rel=0&fs=1&loop=0" allowfullscreen="true" type="application/x-shockwave-flash" wmode="transparent" width="'.$width.'" height="'.$height.'"></embed></object>';
	}

	/**
	 * Get URL of YouTube video screenshot
	 *
	 * This method returns URL of YouTube video screenshot. It can get one of three screenshots defined by YouTube
	 *
	 * @access public
	 * @param string $url YouTube video URL. If this cannot be parsed it will be used as video ID. It can be omitted
	 * @param integer $imgid Number of screenshot to be returned. It can be 1, 2 or 3
	 * @return string URL of YouTube video screenshot
	 */

	public function GetImgURL($url = null, $imgid = 1) {
		if ($url == null)
			$videoid = $this->id;
		else
		{
			$videoid = YouTube::parseURL($url);
			if (!$videoid) $videoid = $url;
		}

		return "http://img.youtube.com/vi/$videoid/$imgid.jpg";
	}

	/**
	 * Get URL of YouTube video screenshot
	 *
	 * This method returns URL of YouTube video screenshot. It can get one of three screenshots defined by YouTube
	 * DEPRECATED! Use GetImgURL instead.
	 *
	 * @deprecated
	 * @see GetImgURL
	 * @access public
	 * @param string $url YouTube video URL. If this cannot be parsed it will be used as video ID. It can be omitted
	 * @param integer $imgid Number of screenshot to be returned. It can be 1, 2 or 3
	 * @return string URL of YouTube video screenshot
	 */

	public function GetImg($url = null, $imgid = 1)
	{
		return GetImgURL($url, $imgid);
	}

	/**
	 * Get YouTube screenshot HTML embed code
	 *
	 * This method returns HTML code which is used to embed YouTube video screenshot in page
	 *
	 * @access public
	 * @param string $url YouTube video URL. If this cannot be parsed it will be used as video ID
	 * @param integer $imgid Number of screenshot to be returned. It can be 1, 2 or 3
	 * @param string $alt Alternate text of the screenshot
	 * @return string HTML code which embeds YouTube video screenshot
	 */

	public function ShowImg($url = null, $imgid = 1, $alt = 'Video screenshot') {
		return "<img src='".$this->GetImgURL($url, $imgid)."' width='122' border='0' alt='".$alt."' title='".$alt."' />";
	}

}

?>
