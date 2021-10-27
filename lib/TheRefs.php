<?php
/**
* Class for working with BibTex data in HTML papers
*
* PHP version 5
*/
//require_once 'Structures/BibTex.php';
require_once 'bibtexbrowser.php';
	
class TheRefs {
	
	/**
     * BibTeX structure using the BibTeX file data
     *
     * @access private
     * @var BibDataBase
     */
	var $_bibDataBase;

	/**
     * Array mapping bibref to index in _bibtexStruct and index in paper if referenced
     *
     * @access private
     * @var array
     */
	var $_citeMap;

	/**
     * Array mapping index in paper to _bibtexStruct data for this entry
     *
     * @access private
     * @var array
     */
	var $referenced;

	/**
     * The last index used so far in the paper
     *
     * @access private
     * @var int
     */
	var $_lastrefnum;
	
	/**
     * Constructor
     *
     * @access public
     * @return void
     */
	function TheRefs($filename) {
		
		$this->_lastrefnum = 0;
		$this->referenced = array();
		
		$this->_bibDataBase = new BibDataBase();
		$this->_bibDataBase->load($filename);

		$this->_citeMap = array();

	}

    /**
     * Gets the entry from the bib file using its bibkey
     *
     * @access public
     * @param string $bibkey the BibTeX key of the entry in the file
     * @return the database entry
     */
    function getEntry($bibkey) {
        return $this->_bibDataBase->getEntryByKey($bibkey);
    }

	/**
     * Adds an entry to the references if not yet added, then write the ref in the paper
     *
     * @access public
     * @param string $cites comma separated bibkeys
     * @return HTML that must be input in the text body
     */
    function cite($cites) {
        $refResult = "[";
        $commaOrNot = "";
        foreach(explode(",",$cites) as $bibkey) {
            // If already referenced
            if(isset($this->_citeMap[$bibkey])) {
                $indexInRef = $this->_citeMap[$bibkey];
                $bibRefLabel = $GLOBALS["bibrefs"][$bibkey];
            }
            else {
                $indexInRef = ++$this->_lastrefnum;
                $this->_citeMap[$bibkey] = $indexInRef;
                $this->referenced[$bibkey] = $this->_bibDataBase->getEntryByKey($bibkey);
                $bibRefLabel = $GLOBALS["bibrefs"][$bibkey];
            }
            
            $refResult .= $commaOrNot . "<a href=\"#ref-". $bibkey . "\">" . $bibRefLabel . "</a>";
            $commaOrNot = ", ";
        }
        return $refResult . "]";
    }

    /**
     * Adds an entry to the references if not yet added, then write the ref in the paper with authors
     *
     * @access public
     * @param string $cite bibkey (we assume one bibkey)
     * @return HTML that must be input in the text body
     */
    function citet($cite) {
        $refResult = $this->cite($cite);
        /*$auth = "";
        $entry = $this->_bibDataBase->getEntryByKey($cite);
        if($entry->hasField("author")) {
            $auth = $entry->getCompactedAuthors();
        }
        elseif($entry->hasField("editor")) {
            $auth = $entry->getCompactedEditors();
        }
        return $auth . " " . $refResult;*/
        $bibRefLabel = $GLOBALS["bibrefs"][$cite];
        list($name, $year) = preg_split("/, /", $bibRefLabel);
        return "<a href=\"#ref-". $cite . "\">" . $name . " [" . $year . "]</a>";
    }

    /**
     * Adds an entry to the references if not yet added, then write the ref in the paper with authors
     *
     * @access public
     * @param string $cite bibkey (we assume one bibkey)
     * @return HTML that must be input in the text body
     */
    function citeH($cite) {
        /*$refResult = $this->cite($cite);
        $auth = "";
        $entry = $this->_bibDataBase->getEntryByKey($cite);
        if($entry->hasField("author")) {
            $auth = $entry->getCompactedAuthors();
        }
        elseif($entry->hasField("editor")) {
            $auth = $entry->getCompactedEditors();
        }
        return $auth . " (" . $entry->getYear() . ") " . $refResult;*/
        return $this->citet($cite);
    }

    /**
     * Write the year of the ref in the paper (assumes ref is already added)
     *
     * @access public
     * @param string $cite bibkey (we assume one bibkey)
     * @return HTML that must be input in the text body
     */
    function citeyear($cite) {
        $entry = $this->_bibDataBase->getEntryByKey($cite);
        return $entry->getYear();
    }
}

?>