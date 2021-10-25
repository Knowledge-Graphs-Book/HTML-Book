<?php
	function writeArticle($entry) {
		$_result = $entry->getFormattedAuthorsString() . ". " . $entry->getYear() . ". ";
		$_beforeTitle = "";
		$_afterTitle = "";
		if($entry->hasField("url")) {
			$_beforeTitle = "<a href=\"" . $entry->getField("url") . "\">";
			$_afterTitle = "</a>";
		}
		$_result .= $_beforeTitle . $entry->getTitle() . $_afterTitle;
		if($entry->hasField("journal")) {
			$_result .= ". <em>" . $entry->getField("journal") . "</em>";
		}
		if($entry->hasField("volume")) {
			$_result .= " " . $entry->getField("volume");
		}
		if($entry->hasField("number")) {
			$_result .= "(" . $entry->getField("number") . ")";
		}
		if($entry->hasField("pages")) {
			$_pages = $entry->getField('pages');
			if(mb_strpos($_pages,"–")) {
				$_result .= ", " . $_pages;
			}
			else {
				$_result .= ", p" . $_pages;
			}
		}
		elseif($entry->hasField("numpages")) {
			$_result .= ". " . $entry->getField("numpages") . " pages";
		}
		return $_result . ".";
	}
	function writeBook($entry) {
		$_result = "";
		if($entry->hasField("author")) {
			$_result .= $entry->getFormattedAuthorsString();
		}
		elseif($entry->hasField("editor")) {
			$_result .= $entry->getFormattedEditorsString();
		}
		$_result .= ". " . $entry->getYear() . ". ";
		$_beforeTitle = "<em>";
		$_afterTitle = "</em>";
		if($entry->hasField("url")) {
			$_beforeTitle = "<em><a href=\"" . $entry->getField("url") . "\">";
			$_afterTitle = "</a></em>";
		}
		$_result .= $_beforeTitle . $entry->getTitle() . $_afterTitle;
		if($entry->hasField("series")) {
			$_result .= ". " . $entry->getField("series");
		}
		if($entry->hasField("volume")) {
			$_result .= ", vol.&nbsp;" . $entry->getField("volume");
		}
		if($entry->hasField("publisher")) {
			$_result .= ". " . $entry->getField("publisher");
		}
		if($entry->hasField("numpages")) {
			$_result .= ". " . $entry->getField("numpages") . " pages";
		}
		return $_result . ".";
	}
	function writeInCollection($entry) {
		$_result .= $entry->getFormattedAuthorsString() . ". " . $entry->getYear() . ". ";
		$_beforeTitle = "";
		$_afterTitle = "";
		if($entry->hasField("url")) {
			$_beforeTitle = "<a href=\"" . $entry->getField("url") . "\">";
			$_afterTitle = "</a>";
		}
		$_result .= $_beforeTitle . $entry->getTitle() . $_afterTitle;
		if($entry->hasField("booktitle")) {
			$_result .= ". In <em>" . $entry->getField("booktitle") . "</em>";
			if($entry->hasField("editor")) {
				$_result .= ", " . $entry->getFormattedEditorsString();
			}
		}
		if($entry->hasField("series")) {
			$_result .= ". " . $entry->getField("series");
		}
		if($entry->hasField("volume")) {
			$_result .= ", vol.&nbsp;" . $entry->getField("volume");
		}
		if($entry->hasField("publisher")) {
			$_result .= ". " . $entry->getField("publisher");
		}
		if($entry->hasField("pages")) {
			$_pages = $entry->getField('pages');
			if(mb_strpos($_pages,"–")) {
				$_result .= ", " . $_pages;
			}
			else {
				$_result .= ", p" . $_pages;
			}
		}
		elseif($entry->hasField("numpages")) {
			$_result .= ". " . $entry->getField("numpages") . " pages";
		}
		return $_result . ".";
	}
	function writeInProceedings($entry) {
		$_result .= $entry->getFormattedAuthorsString() . ". " . $entry->getYear() . ". ";
		$_beforeTitle = "";
		$_afterTitle = "";
		if($entry->hasField("url")) {
			$_beforeTitle = "<a href=\"" . $entry->getField("url") . "\">";
			$_afterTitle = "</a>";
		}
		$_result .= $_beforeTitle . $entry->getTitle() . $_afterTitle;
		if($entry->hasField("booktitle")) {
			$_result .= ". In <em>" . $entry->getField("booktitle") . "</em>";
			if($entry->hasField("editor")) {
				$_result .= ", " . $entry->getFormattedEditorsString();
			}
		}
		if($entry->hasField("series")) {
			$_result .= ". " . $entry->getField("series");
		}
		if($entry->hasField("volume")) {
			$_result .= ", vol.&nbsp;" . $entry->getField("volume");
		}
		if($entry->hasField("publisher")) {
			$_result .= ". " . $entry->getField("publisher");
		}
		if($entry->hasField("pages")) {
			$_pages = $entry->getField('pages');
			if(mb_strpos($_pages,"–")) {
				$_result .= ", " . $_pages;
			}
			else {
				$_result .= ", p" . $_pages;
			}
		}
		elseif($entry->hasField("numpages")) {
			$_result .= ". " . $entry->getField("numpages") . " pages";
		}
		return $_result . ".";
	}
	function writeManual($entry) {
		$_result = $entry->getField("organization") . ". " . $entry->getYear() . ". ";
		$_beforeTitle = "";
		$_afterTitle = "";
		if($entry->hasField("url")) {
			$_beforeTitle = "<a href=\"" . $entry->getField("url") . "\">";
			$_afterTitle = "</a>";
		}
		$_result .= $_beforeTitle . $entry->getTitle() . $_afterTitle;
		if($entry->hasField(HOWPUBLISHED)) {
			$_result .= ". " . $entry->getField(HOWPUBLISHED);
		}
		if($entry->hasField("month")) {
			$_result .= ". " . $entry->getField("month") . ", " . $entry->getYear();
		}
		if($entry->hasField("numpages")) {
			$_result .= ". " . $entry->getField("numpages") . " pages";
		}
		return $_result . ".";
	}
	function writeMisc($entry) {
		$_result = $entry->getFormattedAuthorsString() . ". " . $entry->getYear() . ". ";
		$_beforeTitle = "";
		$_afterTitle = "";
		if($entry->hasField("url")) {
			$_beforeTitle = "<a href=\"" . $entry->getField("url") . "\">";
			$_afterTitle = "</a>";
		}
		$_result .= $_beforeTitle . $entry->getTitle() . $_afterTitle;
		if($entry->hasField(HOWPUBLISHED)) {
			$_result .= ". " . $entry->getField(HOWPUBLISHED);
		}
		if($entry->hasField("month")) {
			$_result .= ". " . $entry->getField("month") . ", " . $entry->getYear();
		}
		if($entry->hasField("numpages")) {
			$_result .= ". " . $entry->getField("numpages") . " pages";
		}
		return $_result . ".";
	}
	function writePhdThesis($entry) {
		$_result = $entry->getFormattedAuthorsString() . ". " . $entry->getYear() . ". ";
		$_beforeTitle = "<em>";
		$_afterTitle = "</em>";
		if($entry->hasField("url")) {
			$_beforeTitle = "<em><a href=\"" . $entry->getField("url") . "\">";
			$_afterTitle = "</a></em>";
		}
		$_result .= $_beforeTitle . $entry->getTitle() . $_afterTitle;
		$_result .= ". Ph.D. dissertation. " . $entry->getField("school");
		return $_result . ".";
	}
	function writeTechReport($entry) {
		$_result = $entry->getFormattedAuthorsString() . ". " . $entry->getYear() . ". ";
		$_beforeTitle = "<em>";
		$_afterTitle = "</em>";
		if($entry->hasField("url")) {
			$_beforeTitle = "<em><a href=\"" . $entry->getField("url") . "\">";
			$_afterTitle = "</a></em>";
		}
		$_result .= $_beforeTitle . $entry->getTitle() . $_afterTitle;
		if($entry->hasField("type")) {
			$_result .= ". " . $entry->getField("type");
		}
		if($entry->hasField("institution")) {
			$_result .= ". " . $entry->getField("institution");
		}
		if($entry->hasField("month")) {
			$_result .= ". " . $entry->getField("month") . ", " . $entry->getYear();
		}
		if($entry->hasField("numpages")) {
			$_result .= ". " . $entry->getField("numpages") . " pages";
		}
		return $_result . ".";
	}
	function writeRefLabel($entry) {
		$_reflabel = ""; $etal = "";
		if($entry->hasField("editor")) {
			$_thecreators = $entry->getRawEditors();
		}
		if($entry->hasField("author")) {
			$_thecreators = $entry->getRawAuthors();
		} 
		if(count($_thecreators) == 0) {
			return "ANONYMOUS, " . $entry->getYear();
		}
		if(count($_thecreators) == 2) {
			return $entry->getLastName($_thecreators[0]) . " and " . $entry->getLastName($_thecreators[1]) . ", " . $entry->getYear();
		}
		if(count($_thecreators) > 2) {
			$etal = " et al.";
		}
		return $entry->getLastName($_thecreators[0]) . $etal . ", " . $entry->getYear();
	}

?>

	<section id="sec-references" class="prechapter">
		<h2 id="bibliography">Bibliography</h2>
		<ul class="reflist">
<?php
	foreach($GLOBALS["bibrefs"] as $indexInRef => $reflabel) {
		if($entry = $references->referenced[$indexInRef]) {
			echo "\t\t\t<li id=\"ref-" . $entry->getKey() . "\">\n\t\t\t\t<p>";//<strong>[" . $indexInRef . "]</strong> ";
			if($entry->getType() == "article")
				echo writeArticle($entry);
			if($entry->getType() == "incollection")
				echo writeInCollection($entry);
			if($entry->getType() == "inproceedings")
				echo writeInProceedings($entry);
			if($entry->getType() == "book")
				echo writeBook($entry);
			if($entry->getType() == "manual")
				echo writeManual($entry);
			if($entry->getType() == "misc")
				echo writeMisc($entry);
			if($entry->getType() == "phdthesis")
				echo writePhdThesis($entry);
			if($entry->getType() == "techreport")
				echo writeTechReport($entry);
			echo "</p>\n\t\t\t\t<pre><code class=\"language-bib\">";
			echo $entry->getText();
			echo "</code></pre>\n\t\t\t</li>\n";
		}
		else {
			echo "\t\t\t<li class=\"ref-NONE\"><strong>[" . $indexInRef . "]</strong> NO REFERENCE</li>\n";
		}
	}
?>
		</ul>
	</section>
