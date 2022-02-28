<?php
	require_once "lib/helper.php";
	require_once "lib/TheRefs.php";
	$references = new TheRefs("bib/biblio.bib");
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<title>Knowledge Graphs</title>
	<meta charset="UTF-8"/>
<!--	<script src="https://polyfill.io/v3/polyfill.min.js?features=es6"></script>
	<script id="MathJax-script" async="async" src="https://cdn.jsdelivr.net/npm/mathjax@3/es5/tex-mml-chtml.js"></script>-->
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/katex@0.13.18/dist/katex.min.css" integrity="sha384-zTROYFVGOfTw7JV7KUu8udsvW2fx4lWOsCEDqhBreBwlHI4ioVRtmIvEThzJHGET" crossorigin="anonymous">
	<script defer src="https://cdn.jsdelivr.net/npm/katex@0.13.18/dist/katex.min.js" integrity="sha384-GxNFqL3r9uRJQhR+47eDxuPoNE7yLftQM8LcxzgS4HT73tp970WS/wV5p8UzCOmb" crossorigin="anonymous"></script>
	<script defer src="https://cdn.jsdelivr.net/npm/katex@0.13.18/dist/contrib/auto-render.min.js" integrity="sha384-vZTG03m+2yp6N6BNi5iM4rW4oIwk5DfcNdFfxkk9ZWpDriOkXX8voJBFrAO7MpVl" crossorigin="anonymous" onload="renderMathInElement(document.body);"></script>
	<link rel="stylesheet" href="css/style.css"/>
	<link rel="stylesheet" href="css/prism.css"/>
	<link rel="stylesheet" href="css/fonts.css"/>
	<meta name="twitter:card" content="summary">
	<meta name="twitter:title" content="Knowledge Graphs">
	<meta name="twitter:description" content="Knowledge Graphs: This open access HTML book provides a comprehensive and accessible introduction to knowledge graphs.">
	<meta name="twitter:image" content="https://www.emse.fr/~zimmermann/KGBook/HTML-Book/images/small-cover.jpg">
	<script src="js/prism.js"></script>
	<!--<script src="https://cdnjs.cloudflare.com/ajax/libs/prism/1.17.1/prism.min.js"></script>-->
	<script src="https://saswatpadhi.github.io/prismjs-bibtex/prism-bibtex.min.js"></script>
	<style>
		.gnode .katex,
		.ginode .katex {
			font-size: 90%;
			padding: 0 .2em 0 .2em;
		}
		.katex {
			font-size: 99%;
		}
	</style>
</head>
<body>
	<!-- What follows are macros if one uses MathJax instead of KaTeX -->
	<!--<div style="display:none" id="tex-macros">
		\(
\newcommand{\coloneqq}{\mathrel{\vcenter{:}}=}
\newcommand{\con}{\mathbf{Con}}
\newcommand{\var}{\mathbf{Var}}
\newcommand{\term}{\mathbf{Term}}
\newcommand{\dom}{\mathbf{dom}}
\newcommand{\datatype}[1]{\Delta_{#1}}
\newcommand{\datatypeL}[1]{\datatype{\texttt{#1}}}
\newcommand{\gelab}[1]{{\color{blue}\textsf{#1}}}
\newcommand\arc[2]{\xrightarrow{#1}#2}
\newcommand{\qualified}[4]{\arc{#1}{#2}\{#3,#4\}}
\newcommand{\qualifiedcard}[3]{\arc{#1}{#2}~#3}
\newcommand{\qualifiedL}[4]{\qualified{\gelab{#1}}{#2}{#3}{#4}}
\newcommand{\qualifiedcardL}[3]{\qualifiedcard{\gelab{#1}}{#2}{#3}}
\newcommand{\semantics}[4]{[#1]^{#2,#3,#4}}
\newcommand{\inp}[1]{#1^I}
\newcommand{\inpdom}{\inp{\Delta}}
\newcommand{\T}[1]{#1^{\rm T}}
\newcommand{\D}[1]{#1^{\rm D}}
		\)
	</div>-->
	<script>
		// This script defines parameters and macros for KaTeX, to render math formulas
    document.addEventListener("DOMContentLoaded", function() {
        renderMathInElement(document.body, {
          // customised options
          // • auto-render specific keys, e.g.:
          delimiters: [
              {left: '$$', right: '$$', display: true},
              {left: '\\(', right: '\\)', display: false},
              {left: "\\begin{equation}", right: "\\end{equation}", display: true},
						  {left: "\\begin{align*}", right: "\\end{align*}", display: true},
						  {left: "\\begin{alignat}", right: "\\end{alignat}", display: true},
						  {left: "\\begin{gather}", right: "\\end{gather}", display: true},
						  {left: "\\begin{CD}", right: "\\end{CD}", display: true},
						  {left: '\\[', right: '\\]', display: true}
			    ],
          macros: {
          	"\\coloneqq": "\\mathrel{\\vcenter{:}}=",
						"\\con": "\\mathbf{Con}",
						"\\var": "\\mathbf{Var}",
						"\\term": "\\mathbf{Term}",
						"\\dom": "\\mathbf{dom}",
						"\\datatype": "\\Delta_{#1}",
						"\\datatypeL": "\\datatype{\\texttt{#1}}",
						"\\gelab": "{\\color{blue}\\textsf{#1}}",
						"\\arc": "\\xrightarrow{#1}#2",
						"\\qualified": "\\arc{#1}{#2}\\{#3,#4\\}",
						"\\qualifiedcard": "\\arc{#1}{#2}~#3",
						"\\qualifiedL": "\\qualified{\\gelab{#1}}{#2}{#3}{#4}",
						"\\qualifiedcardL": "\\qualifiedcard{\\gelab{#1}}{#2}{#3}",
						"\\semantics": "[#1]^{#2,#3,#4}",
						"\\inp": "#1^I",
						"\\inpdom": "\\inp{\\Delta}",
						"\\T": "#1^{\\rm T}",
						"\\D": "#1^{\\rm D}"
          }
        });
    });
	</script>
	<div class="cover">
		<img alt="book cover" src="images/cover-no-text.jpg"/>
		<p style="position:absolute;top:300px;font-size:109px;text-shadow:5px 5px 5px black;font-weight:bold;">KNOWLEDGE<br/>GRAPHS</p>
		<p style="position:absolute;top:700px;font-size:29px;text-shadow:3px 3px 3px black;"><a href="#bio-hogan">Aidan Hogan</a> | <a href="#bio-blomqvist">Eva Blomqvist</a> | <a href="#bio-cochez">Michael Cochez</a><br/><a href="#bio-damato">Claudia d’Amato</a> | <a href="#bio-demelo">Gerard de Melo</a> | <a href="#bio-gutierrez">Claudio Gutierrez</a><br/><a href="#bio-kirrane">Sabrina Kirrane</a> | <a href="#bio-labragayo">José Emilio Labra Gayo</a> | <a href="#bio-navigli">Roberto Navigli</a><br/><a href="#bio-neumaier">Sebastian Neumaier</a> | <a href="#bio-ngongangomo">Axel-Cyrille Ngonga Ngomo</a><br/><a href="#bio-polleres">Axel Polleres</a> | <a href="#bio-rashid">Sabbir M. Rashid</a> | <a href="#bio-rula">Anisa Rula</a><br/><a href="#bio-schmelzeisen">Lukas Schmelzeisen</a> | <a href="#bio-sequeda">Juan Sequeda</a><br/><a href="#bio-staab">Steffen Staab</a> | <a href="#bio-zimmermann">Antoine Zimmermann</a></p>
	</div>
	<div id="aboutlink">Give us feedback!<div>You can <a href="https://github.com/Knowledge-Graphs-Book/HTML-Book/issues">leave comments</a> on the HTML book as issues to our <a href="https://github.com/Knowledge-Graphs-Book/HTML-Book/">Github repository</a>. You can also address your feedback on the book by email to:<br /> <code>kg-tutorial [at] googlegroups [dot] com</code></div></div>
	<header>
		<h1 id="title"><span class="big-letter">K</span>nowledge <span class="big-letter">G</span>raphs</h1>
		<ul class="authorlist">
			<li><span class="author"><a href="https://orcid.org/0000-0001-9482-1982">Aidan Hogan</a></span> <span class="affiliation">IMFD, DCC, Universidad de Chile <span class="country">Chile</span></span></li>
			<li><span class="author"><a href="https://orcid.org/0000-0003-0036-6662">Eva Blomqvist</a></span> <span class="affiliation">Linköping University <span class="country">Sweden</span></span></li>
			<li><span class="author"><a href="https://orcid.org/0000-0001-5726-4638">Michael Cochez</a></span> <span class="affiliation">Vrije Universiteit Amsterdam and Discovery Lab, Elsevier <span class="country">The Netherlands</span></span></li>
			<li><span class="author"><a href="https://orcid.org/0000-0002-3385-987X">Claudia d’Amato</a></span> <span class="affiliation">University of Bari <span class="country">Italy</span></span></li>
			<li><span class="author"><a href="https://orcid.org/0000-0002-2930-2059">Gerard de Melo</a></span> <span class="affiliation">HPI, University of Potsdam and Rutgers University <span class="country">USA</span></span></li>
			<li><span class="author"><a href="https://orcid.org/0000-0002-4559-6544">Claudio Gutierrez</a></span> <span class="affiliation">IMFD, DCC, Universidad de Chile <span class="country">Chile</span></span></li>
			<li><span class="author"><a href="https://orcid.org/0000-0002-6955-7718">Sabrina Kirrane</a></span> <span class="affiliation">WU Vienna <span class="country">Austria</span></span></li>
			<li><span class="author"><a href="https://orcid.org/0000-0001-8907-5348">José Emilio Labra Gayo</a></span> <span class="affiliation">Universidad de Oviedo <span class="country">Spain</span></span></li>
			<li><span class="author"><a href="https://orcid.org/0000-0003-3831-9706">Roberto Navigli</a></span> <span class="affiliation">Sapienza University of Rome <span class="country">Italy</span></span></li>
			<li><span class="author"><a href="https://orcid.org/0000-0002-9804-4882">Sebastian Neumaier</a></span> <span class="affiliation">St. Pölten University of Applied Sciences <span class="country">Austria</span></span></li>
			<li><span class="author"><a href="https://orcid.org/0000-0001-7112-3516">Axel-Cyrille Ngonga Ngomo</a></span> <span class="affiliation">DICE, Universität Paderborn <span class="country">Germany</span></span></li>
			<li><span class="author"><a href="https://orcid.org/0000-0001-5670-1146">Axel Polleres</a></span> <span class="affiliation">WU Vienna <span class="country">Austria</span></span></li>
			<li><span class="author"><a href="https://orcid.org/0000-0002-4162-8334">Sabbir M. Rashid</a></span> <span class="affiliation">Tetherless World Constellation, Rensselaer Polytechnic Institute <span class="country">USA</span></span></li>
			<li><span class="author"><a href="https://orcid.org/0000-0002-8046-7502">Anisa Rula</a></span> <span class="affiliation">University of Brescia <span class="country">Italy</span></span></li>
			<li><span class="author"><a href="https://orcid.org/0000-0002-2108-2303">Lukas Schmelzeisen</a></span> <span class="affiliation">Universität Stuttgart <span class="country">Germany</span></span></li>
			<li><span class="author"><a href="https://orcid.org/0000-0003-3112-9299">Juan Sequeda</a></span> <span class="affiliation">data.world <span class="country">USA</span></span></li>
			<li><span class="author"><a href="https://orcid.org/0000-0002-0780-4154">Steffen Staab</a></span> <span class="affiliation">Universität Stuttgart <span class="country">Germany</span> and University of Southampton <span class="country">UK</span></span></li>
			<li><span class="author"><a href="https://orcid.org/0000-0003-1502-6986">Antoine Zimmermann</a></span> <span class="affiliation">École des mines de Saint-Étienne <span class="country">France</span></span></li>
		</ul>
		<div id="about" class="info">
			<h2>About the book</h2>
			<p>The book is published by <a href="http://www.morganclaypool.com/">Morgan &amp; Claypool</a> in the series <a href="http://www.morganclaypool.com/toc/wbe.1/7/1">Synthesis Lectures on the Data, Semantics, and Knowledge</a> edited by <a href="http://info.slis.indiana.edu/~dingying/">Ying Ding</a> and Paul Groth. Please, cite the book as:</p>
			<blockquote class="quote">
				 Aidan Hogan, Eva Blomqvist, Michael Cochez, Claudia d’Amato, Gerard de Melo, Claudio Gutierrez, Sabrina Kirrane, José Emilio Labra Gayo, Roberto Navigli, Sebastian Neumaier, Axel-Cyrille Ngonga Ngomo, Axel Polleres, Sabbir M. Rashid, Anisa Rula, Lukas Schmelzeisen, Juan Sequeda, Steffen Staab, Antoine Zimmermann (2021) <em>Knowledge Graphs</em>, Synthesis Lectures on Data, Semantics, and Knowledge, No. 22, 1–237, DOI: 10.2200/S01125ED1V01Y202109DSK022, Morgan &amp; Claypool
			</blockquote>
			<p>BibTeX entry of this book:</p>
			<pre><code class="language-bib">@book{kg-book,
  author = {Hogan, Aidan and Blomqvist, Eva and Cochez, Michael and
d'Amato, Claudia and de Melo, Gerard and Guti\'errez, Claudio and
Kirrane, Sabrina and Labra Gayo, Jos\'e Emilio and Navigli, Roberto and
Neumaier, Sebastian and Ngonga Ngomo, Axel-Cyrille and Polleres, Axel and
Rashid, Sabbir M. and Rula, Anisa and Schmelzeisen, Lukas and
Sequeda, Juan F. and Staab, Steffen and Zimmermann, Antoine},
  doi = {10.2200/S01125ED1V01Y202109DSK022},
  isbn = {9781636392363},
  language = {English},
  number = {22},
  numpages = {237},
  publisher = {Morgan \& Claypool},
  series = {Synthesis Lectures on Data, Semantics, and Knowledge},
  title = {{K}nowledge {G}raphs},
  url = {https://kgbook.org/},
  year = {2021}
}</code></pre>
			<dl>
				<dt>ISBN paperback:</dt>
				<dd>9781636392356</dd>
				<dt>ISBN ebook:</dt>
				<dd>9781636392363</dd>
				<dt>ISBN hardcover:</dt>
				<dd>9781636392370</dd>
			</dl>
			<p>Copyright © 2021 by Morgan &amp; Claypool. All rights reserved.</p>
			<!--<p><a href="bibtex.txt">Bibtex</a></p>-->
			<h2 id="access">Access options</h2>
			<dl>
				<dt>HTML version:</dt>
				<dd>You are currently reading the free HTML version of the book, the most recent of which is available at <a href="https://kgbook.org/">https://kgbook.org/</a>.<sup class="fnmark" id="fnm_a"><a href="#fn_a">*</a></sup><span class="footnote" id="fn_a"><sup><a href="#fnm_a">note *</a></sup> You can see the scripts that generate this page on our <a href="https://github.com/Knowledge-Graphs-Book/HTML-Book/">Github repository</a> and <a href="https://github.com/Knowledge-Graphs-Book/HTML-Book/issues">leave comments</a> as new issues. You can also address your feedback on the book by email to <code>kg-tutorial [at] googlegroups [dot] com</code>. <a href="https://github.com/Knowledge-Graphs-Book/examples">Example code and associated resources</a> can be found on Github as well.</span></dd>
				<dt>PDF Version:</dt>
				<dd>You can download or buy the book from <a href="http://www.morganclaypoolpublishers.com/catalog_Orig/product_info.php?products_id=1683">Morgan &amp; Claypool</a>. Academic and Corporate licences are available.</dd>
				<dt>Hard copy:</dt>
				<dd>You can order from <a href="http://www.morganclaypoolpublishers.com/catalog_Orig/product_info.php?products_id=1683">Morgan &amp; Claypool</a> or <a href="https://www.amazon.com/Knowledge-Graphs-Synthesis-Lectures-Semantics/dp/1636392350/ref=sr_1_11?keywords=Knowledge+Graphs&qid=1637308294&sr=8-11">Amazon</a>.</dd>
			</dl>
		</div>
		<p><em>SYNTHESIS LECTURES ON ON DATA, SEMANTICS, AND KNOWLEDGE #22</em></p>
	</header>
	<h2 id="abstract"><span>Abstract</span></h2>
	<p>This book provides a comprehensive and accessible introduction to knowledge graphs, which have recently garnered notable attention from both industry and academia.</p>
	<p>Knowledge graphs are founded on the principle of applying a graph-based abstraction to data, and are now broadly deployed in scenarios that require integrating and extracting value from multiple, diverse sources of data at large scale. The book defines knowledge graphs and provides a high-level overview of how they are used. It presents and contrasts popular graph models that are commonly used to represent data as graphs, and the languages by which they can be queried before describing how the resulting data graph can be enhanced with notions of schema, identity, and context. The book discusses how ontologies and rules can be used to encode knowledge as well as how inductive techniques — based on statistics, graph analytics, machine learning, etc. — can be used to encode and extract knowledge. It covers techniques for the creation, enrichment, assessment, and refinement of knowledge graphs and surveys recent open and enterprise knowledge graphs and the industries or applications within which they have been most widely adopted. The book closes by discussing the current limitations and future directions along which knowledge graphs are likely to evolve.</p>
	<p>This book is aimed at students, researchers, and practitioners who wish to learn more about knowledge graphs and how they facilitate extracting value from diverse data at large scale. To make the book accessible for newcomers, running examples and graphical notation are used throughout. Formal definitions and extensive references are also provided for those who opt to delve more deeply into specific topics.</p>
	<h2 id="keywords"><span>Keywords</span></h2>
	<p>knowledge graphs, graph databases, knowledge graph embeddings, graph neural networks, ontologies, knowledge graph refinement, knowledge graph quality, knowledge bases, artificial intelligence, semantic web, machine learning</p>

<?php
	include("toc.php");
	include("preface.php");
	include("ack.php");
	include("chapters/01-intro.php");
	include("chapters/02-graph.php");
	include("chapters/03-knowledge.php");
	include("chapters/04-deductive.php");
	include("chapters/05-inductive.php");
	include("chapters/06-creation.php");
	include("chapters/07-quality.php");
	include("chapters/08-refinement.php");
	include("chapters/09-publication.php");
	include("chapters/10-kg.php");
	include("chapters/11-conclude.php");
$references->cite("peirce,frege,richens58,milgram,Brachman,woods,sowa,sowa2,BrachmanS85,Schmidt-SchaussS91,berners-lee01,NavigliPonzetto:12,bollacker2007platform,suchanek2007yago,Kummel73,rada1986gradualness,Bakker,stokman1988structuring,james,Hoede95,Popping03,zhang,NurdiatiH08,rappaport1988dynamic,SrikanthJ89,de1990hybrid,MachadoR90,DiengGTC92,ShimonyDS97,JrS99,Jiang02,HelmsB05,KasneciSIRW08,ElbassuoniRSSW09,CourseyM09,PechsiriP10,CorbyF10,ciampaglia2015computational,MarchiM74,nickel,SeufertEBKBW16,BuchananF78,GuarinoOS9,rdf11sem,CormanFRS19a,BrachmanL85,sylvester");
	include("chapters/references.php");
	include("appendices/history.php");
	include("bio.php");
?>
	<h2 id="theend"><span>The End</span></h2>
</body>
</html>