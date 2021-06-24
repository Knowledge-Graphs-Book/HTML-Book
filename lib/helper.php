<?php
	define("NOARROW", 0);
	define("RIGHTARROW", 1);
	define("LEFTARROW", 2);
	define("LEFTRIGHTARROW", 3);
	$GLOBALS["footnotemark"] = 1;
	$GLOBALS["refnumbers"] = 
		array(
			// Appendices
			"chap-defs" => "A",
			// Definitions
			"def-delg" => "2.1",
			"def-hg" => "2.2",
			"def-pg" => "2.3",
			"def-gd" => "2.4",
			"def-delgp" => "2.5",
			"def-pgp" => "2.6",
			"def-evgp" => "2.7",
			"def-cgp" => "2.8",
			"def-evalcgp" => "2.9",
			"def-anndom" => "24",
			"def-ent" => "29",
			"def-dvlg" => "36",
			"def-gpf" => "37",
			// Examples
			"ex-dvlg" => "11",
			// Figures
			"fig-delg" => "2.1",
			"fig-capital" => "2.2",
			"fig-cap" => "2.2a",
			"fig-hg" => "2.2b",
			"fig-fsa" => "2.3",
			"fig-pg" => "2.4",
			"fig-gd" => "2.5",
			"fig-gp" => "2.6",
			"fig-cq" => "2.7",
			"fig-cgp" => "2.8",
			"fig-path" => "2.9",
			"fig-ngp" => "2.10",
			"fig-classhier" => "3.1",
			"fig-sg" => "3.2",
			"fig-shapeExample" => "3.3",
			"fig-emergentSchema" => "3.4",
			"fig-emergentSchema2" => "3.5",
			"fig-globalIds" => "3.6",
			"fig-list" => "3.7",
			"fig-temporal" => "3.8",
			"fig-reif" => "3.8a",
			"fig-nary" => "3.8b",
			"fig-singprop" => "3.8c",
			"fig-temporal2" => "3.9",
			"fig-ngraph" => "3.9a",
			"fig-pgc" => "3.9b",
			"fig-rdfstar" => "3.9c",
			"fig-time" => "3.10",
			"fig-bgpFS" => "4.1",
			"fig-qrew" => "4.2",
			"fig-ind" => "5.1",
			"fig-chileTransport" => "5.2",
			"fig-pagerank" => "5.3",
			"fig-transform" => "5.4",
			"fig-TransE" => "5.5",
			"fig-distEg" => "5.5a",
			"fig-transER" => "5.5b",
			"fig-transEE" => "5.5c",
			"fig-cpRank" => "5.6",
			"fig-gnn" => "5.7",
			"fig-airports" => "5.8",
			"fig-textExtract" => "6.1",
			"fig-html" => "6.2",
			"fig-rdbCrime" => "6.3",
			"fig-direct" => "6.4",
			"fig-identity" => "8.1",
			"fig-ld" => "9.1",
			"fig-access" => "9.2",
			"fig-license" => "9.3",
			"fig-usage" => "9.4",
			"fig-crypto" => "9.5",
			"fig-anonymised" => "9.6",
			// Sections
			"chap-graph" => "2",
			"ssec-graphModels" => "2.1",
			"sssec-directedelg" => "2.1.1",
			"subsub-heterograph" => "2.1.2",
			"sssec-propgraph" => "2.1.3",
			"subsub-graphdataset" => "2.1.4",
			"sssec-othergraphs" => "2.1.5",
			"sssec-graphstore" => "2.1.6",
			"ssec-querying" => "2.2",
			"sssec-graphpatterns" => "2.2.1",
			"sssec-complexpatterns" => "2.2.2",
			"sssec-navpatterns" => "2.2.3",
			"app-qother" => "2.2.4",
			"chap-knowledge" => "3",
			"sec-schema" => "3.1",
			"sec-semSchema" => "3.1.1",
			"sssec-validating-schema" => "3.1.2",
			"ssec-emergentSchema" => "3.1.3",
			"sec-identity" => "3.2",
			"subsec-globalIdentifiers" => "3.2.1",
			"sssec-external_identy" => "3.2.2",
			"sssec-datatypes" => "3.2.3",
			"sssec-lexicalisation" => "3.2.4",
			"sssec-existential" => "3.2.5",
			"ssec-knowledgeContext" => "3.3",
			"sssec-direct-representation" => "3.3.1",
			"sec-reify" => "3.3.2",
			"sssec-higher-arity" => "3.3.3",
			"sssec-annotations" => "3.3.4",
			"sssec-other-context" => "3.3.5",
			"chap-deductive" => "4",
			"ssec-ontologies" => "4.1",
			"sssec-interpretations" => "4.1.1",
			"sssec-individuals" => "4.1.2",
			"sssec-properties" => "4.1.3",
			"sssec-classes" => "4.1.4",
			"sssec-other-features" => "4.1.5",
			"sec-ontSemantics" => "4.2",
			"sssec-model-theory" => "4.2.1",
			"sssec-entailment" => "4.2.2",
			"sssec-if-then" => "4.2.3",
			"ssec-reasoning" => "4.3",
			"sec-rules" => "4.3.1",
			"sssec-dls" => "4.3.2",
			"chap-inductive" => "5",
			"sec-gAnalytics" => "5.1",
			"sssec-graph-analytics-tasks" => "5.1.1",
			"sssec-technologies-graph-analytics" => "5.1.2",
			"sssec-query-languages" => "5.1.3",
			"sssec-analyticsQ" => "5.1.4",
			"sssec-analyticsE" => "5.1.5",
			"ssec-embeddings" => "5.2",
			"sssec-translational-models" => "5.2.1",
			"sssec-tensor-decomposition-models" => "5.2.2",
			"sssec-neural-models" => "5.2.3",
			"sssec-language-models" => "5.2.4",
			"sssec-entailment-aware-models" => "5.2.5",
			"ssec-gnns" => "5.3",
			"sssec-recursive-gnn" => "5.3.1",
			"sssec-convolutional-gnn" => "5.3.2",
			"ssec-symlearn" => "5.4",
			"sssec-rule-mining" => "5.4.1",
			"sssec-axiom-mining" => "5.4.2",
			"chap-create" => "6",
			"sssec-graphCreationHuman" => "6.1",
			"sssec-graphCreationText" => "6.2",
			"sssec-pre-processing" => "6.2.1",
			"sssec-ner" => "6.2.2",
			"sssec-el" => "6.2.3",
			"sssec-er" => "6.2.4",
			"sssec-joint-tasks" => "6.2.5",
			"sssec-graphCreationSemistructured" => "6.3",
			"sssec-wrapper-based-extraction" => "6.3.1",
			"sssec-web-table-extraction" => "6.3.2",
			"sssec-deep-web-crawling" => "6.3.3",
			"sssec-graphCreationStructured" => "6.4",
			"sssec-mapping-from-tables" => "6.4.1",
			"sssec-mapping-from-trees" => "6.4.2",
			"sssec-mapping-from-other" => "6.4.3",
			"ssec-knowledgeConceptual" => "6.5",
			"sssec-ontology-engineering" => "6.5.1",
			"sssec-ontology-learning" => "6.5.2",
			"chap-quality" => "7",
			"ssec-accuracy" => "7.1",
			"sssec-syntactic-accuracy" => "7.1.1",
			"sssec-semantic-accuracy" => "7.1.2",
			"sssec-timeliness" => "7.1.3",
			"sssec-coverage" => "7.2",
			"sssec-completeness" => "7.2.1",
			"sssec-representativeness" => "7.2.2",
			"ssec-coherency" => "7.3",
			"sssec-consistency" => "7.3.1",
			"sssec-validity" => "7.3.2",
			"ssec-succinctness" => "7.4",
			"sssec-conciseness" => "7.4.1",
			"sssec-representational-conciseness" => "7.4.2",
			"sssec-understandability" => "7.4.2",
			"ssec-other-quality" => "7.5",
			"chap-refine" => "8",
			"ssec-completion" => "8.1",
			"sssec-general-link-prediction" => "8.1.1",
			"sssec-type-link-prediction" => "8.1.2",
			"sssec-identity-link-prediction" => "8.1.3",
			"ssec-correction" => "8.2",
			"sssec-fact-validation" => "8.2.1",
			"sssec-inconsistency-repairs" => "8.2.2",
			"ssec-other-refinement-tasks" => "8.3",
			"chap-publish" => "9",
			"ssec-principles" => "9.1",
			"ssec-fair" => "9.1.1",
			"sssec-ld" => "9.1.2",
			"ssec-access-protocols" => "9.2",
			"sssec-dumps" => "9.2.1",
			"sssec-node-lookups" => "9.2.2",
			"sssec-edge-patterns" => "9.2.3",
			"sssec-graph-patterns" => "9.2.4",
			"sssec-other-protocols" => "9.2.5",
			"ssec-UsageControl" => "9.3",
			"sssec-licensing" => "9.3.1",
			"sssec-usage-policies" => "9.3.2",
			"sssec-encryption" => "9.3.3",
			"sssec-anonymisation" => "9.3.4",
			"chap-kgs" => "10",
			"sec-openkgs" => "10.1",
			"sssec-dbpedia" => "10.1.1",
			"sssec-yago" => "10.1.2",
			"sssec-freebase" => "10.1.3",
			"sssec-wikidata" => "10.1.4",
			"sssec-other-open-kgs" => "10.1.5",
			"sssec-domain-specific-open-kgs" => "10.1.6",
			"ssec-enterprise-kgs" => "10.2",
			"sssec-web-search" => "10.2.1",
			"sssec-commerce" => "10.2.2",
			"sssec-social-networks" => "10.2.3",
			"sssec-finance" => "10.2.4",
			"sssec-other-industries" => "10.2.5",
			"chap-conclude" => "11",
			// Sections in Appendices
			"app-historical" => "A.1",
			"app-pre2012" => "A.2",
			"app-post2012" => "A.3",
			"app-data-graph" => "B.1",
			"app-directed-graph" => "B.1.1",
			"app-heterogeneous" => "B.1.2",
			"app-property-graph" => "B.1.3",
			"app-dataset" => "B.1.4",
			"app-querying" => "B.2",
			"app-gps" => "B.2.1",
			"app-cgps" => "B.2.2",
			"app-ngps" => "B.2.3",
			"app-schema" => "B.3",
			"app-semantic-schema" => "B.3.1",
			"app-shapes" => "B.3.2",
			"sec-feschema" => "B.3.3",
			"app-context" => "B.4",
			"sec-annotationDomain" => "B.4.1",
			"app-deductive" => "B.5",
			"sec-interpretation" => "B.5.1",
			"app-rules" => "B.5.2",
			"sec-dlformal" => "B.5.3",
			"app-inductive" => "B.6",
			"app-gpfs" => "B.6.1",
			"app-gembeddings" => "B.6.2",
			"app-gnns" => "B.6.3",
			"app-sym" => "B.6.4",
			// Tables
			"tab-related" => "1",
			"tab-semSchema" => "3.1",
			"tab-ontEqIneq" => "4.1",
			"tab-ontProp" => "4.2",
			"tab-ontClass" => "4.3",
			"tab-rulesRdfs" => "4.4",
			"tab-dlsem" => "4.5",
			"tab-kges" => "5.1",
			// Others
			"al-schema" => "2.1"
		);

	function ref($label) {
		$_id = str_replace(":","-",$label);
		if(isset($GLOBALS["refnumbers"][$_id])) {
			$_refnum = $GLOBALS["refnumbers"][$_id];
		}
		else {
			$_refnum = "?";
		}
		return "<a href=\"#$_id\">". $_refnum ."</a>";
	}

	function footnote($string) {
		$_footnotemark = $GLOBALS["footnotemark"]++;
		return "<sup class=\"fnmark\" id=\"fnm$_footnotemark\"><a href=\"#fn$_footnotemark\">$_footnotemark</a></sup><span class=\"footnote\" id=\"fn$_footnotemark\"><sup><a href=\"#fnm$_footnotemark\">note $_footnotemark</a></sup> " . $string . "</span>";
	}

	function esource() {
		return "<img class=\"tip\" src=\"images/edge-source.png\" width=\"8\" alt=\"arrow source\"/>";
	}
	function isource() {
		return "<img class=\"tip\" src=\"images/edge-source2.png\" width=\"8\" alt=\"arrow source\"/>";
	}
	function etipl() {
		return "<img class=\"tip\" src=\"images/edge-revtip.png\" width=\"15\" alt=\"arrow tip leftward\"/>";
	}
	function itipl() {
		return "<img class=\"tip\" src=\"images/edge-revtip2.png\" width=\"15\" alt=\"arrow tip lefttward\"/>";
	}
	function etipr() {
		return "<img class=\"tip\" src=\"images/edge-tip.png\" width=\"15\" alt=\"arrow tip rightward\"/>";
	}
	function itipr() {
		return "<img class=\"tip\" src=\"images/edge-tip2.png\" width=\"15\" alt=\"arrow tip rightward\"/>";
	}

	function gedge($source, $edge, $target, $option = RIGHTARROW) {
		switch ($option) {
			case NOARROW:
				$_left = $_right = esource();
				break;
			case RIGHTARROW:
				$_left = esource();
				$_right = etipr();
				break;
			case LEFTARROW:
				$_left = etipl();
				$_right = esource();
				break;
			case LEFTRIGHTARROW:
				$_left = etipl();
				$_right = etipr();
			default: break;
		}
		return "<span class=\"gnode\">$source</span>$_left<span class=\"edge\">$edge</span>$_right<span class=\"gnode\">$target</span>";
	}

	function giedge($source, $edge, $target, $option = RIGHTARROW) {
		switch ($option) {
			case NOARROW:
				$_left = $_right = isource();
				break;
			case RIGHTARROW:
				$_left = isource();
				$_right = itipr();
				break;
			case LEFTARROW:
				$_left = itipl();
				$_right = isource();
				break;
			case LEFTRIGHTARROW:
				$_left = itipl();
				$_right = itipr();
			default: break;
		}
		return "<span class=\"ginode\">$source</span>$_left<span class=\"iedge\">$edge</span>$_right<span class=\"ginode\">$target</span>";
	}

	function sedge($source, $edge, $card, $target, $nodes ="shap", $option = RIGHTARROW) {
		switch ($option) {
			case NOARROW:
				$_left = $_right = esource();
				break;
			case RIGHTARROW:
				$_left = esource();
				$_right = etipr();
				break;
			case LEFTARROW:
				$_left = etipl();
				$_right = esource();
				break;
			case LEFTRIGHTARROW:
				$_left = etipl();
				$_right = etipr();
			default: break;
		}
		$_annotation = "";
		if(is_null($card)) {
			$_edge = "<span class=\"edge\">$edge</span>";
		}
		else {
			$_edge = "<span class=\"stack\"><span class=\"edge\">$edge</span><br/><span class=\"edge\">$card</span></span>";
		}
		return "<span class=\"$nodes\">$source</span>$_left$_edge$_right<span class=\"$nodes\">$target</span>";
	}

	function LeftJoin($ensuremath = true) {
		$_openmath = $ensuremath ? "\\(" : "";
		$_closemath = $ensuremath ? "\\)" : "";
		return $_openmath ."\\mathbin{\\rule[0ex]{0.3em}{.5pt}\\llap{\\rule[1ex]{0.3em}{.5pt}}\\mkern-6mu\\Join}". $_closemath;
	}
	
?>