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
	<link rel="stylesheet" href="css/style.css"/>
	<link rel="stylesheet" href="css/prism.css"/>
	<link rel="stylesheet" href="css/fonts.css"/>
	<script src="https://polyfill.io/v3/polyfill.min.js?features=es6"></script>
	<script id="MathJax-script" async="async" src="https://cdn.jsdelivr.net/npm/mathjax@3/es5/tex-mml-chtml.js"></script>
	<script src="js/prism.js"></script>
</head>
<body>
	<div style="display:none" id="tex-macros">
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
	</div>
	<div class="cover"><img alt="mock cover" src="images/mock-cover.jpg"/></div>
	<header>
		<h1 id="title"><span class="big-letter">K</span>nowledge <span class="big-letter">G</span>raphs</h1>
		<ul class="authorlist">
			<li><span class="author"><a href="https://orcid.org/0000-0001-9482-1982">Aidan Hogan</a></span> <span class="affiliation">IMFD, DCC, Universidad de Chile <span class="country">Chile</span></span></li>
			<li><span class="author"><a href="https://orcid.org/0000-0003-0036-6662">Eva Blomqvist</a></span> <span class="affiliation">Linköping University <span class="country">Sweden</span></span></li>
			<li><span class="author"><a href="https://orcid.org/0000-0001-5726-4638">Michael Cochez</a></span> <span class="affiliation">Vrije Universiteit and Discovery Lab, Elsevier <span class="country">The Netherlands</span></span></li>
			<li><span class="author"><a href="https://orcid.org/0000-0002-3385-987X">Claudia d’Amato</a></span> <span class="affiliation">University of Bari <span class="country">Italy</span></span></li>
			<li><span class="author"><a href="https://orcid.org/0000-0002-2930-2059">Gerard de Melo</a></span> <span class="affiliation">Rutgers University <span class="country">USA</span></span></li>
			<li><span class="author"><a href="https://orcid.org/0000-0002-4559-6544">Claudio Gutierrez</a></span> <span class="affiliation">IMFD, DCC, Universidad de Chile <span class="country">Chile</span></span></li>
			<li><span class="author"><a href="https://orcid.org/0000-0002-6955-7718">Sabrina Kirrane</a></span> <span class="affiliation">WU Vienna <span class="country">Austria</span></span></li>
			<li><span class="author"><a href="https://orcid.org/0000-0001-8907-5348">José Emilio Labra Gayo</a></span> <span class="affiliation">Universidad de Oviedo <span class="country">Spain</span></span></li>
			<li><span class="author"><a href="https://orcid.org/0000-0003-3831-9706">Roberto Navigli</a></span> <span class="affiliation">Sapienza University of Rome <span class="country">Italy</span></span></li>
			<li><span class="author"><a href="https://orcid.org/0000-0002-9804-4882">Sebastian Neumaier</a></span> <span class="affiliation">WU Vienna <span class="country">Austria</span></span></li>
			<li><span class="author"><a href="https://orcid.org/0000-0001-7112-3516">Axel-Cyrille Ngonga Ngomo</a></span> <span class="affiliation">DICE, Universität Paderborn <span class="country">Germany</span></span></li>
			<li><span class="author"><a href="https://orcid.org/0000-0001-5670-1146">Axel Polleres</a></span> <span class="affiliation">WU Vienna <span class="country">Austria</span></span></li>
			<li><span class="author"><a href="https://orcid.org/0000-0002-4162-8334">Sabbir M. Rashid</a></span> <span class="affiliation">Tetherless World Constellation, Rensselaer Polytechnic Institute <span class="country">USA</span></span></li>
			<li><span class="author"><a href="https://orcid.org/0000-0002-8046-7502">Anisa Rula</a></span> <span class="affiliation">University of Milano-Bicocca <span class="country">Italy</span> and University of Bonn <span class="country">Germany</span></span></li>
			<li><span class="author"><a href="https://orcid.org/0000-0002-2108-2303">Lukas Schmelzeisen</a></span> <span class="affiliation">Universität Stuttgart <span class="country">Germany</span></span></li>
			<li><span class="author"><a href="https://orcid.org/0000-0003-3112-9299">Juan Sequeda</a></span> <span class="affiliation">data.world <span class="country">USA</span></span></li>
			<li><span class="author"><a href="https://orcid.org/0000-0002-0780-4154">Steffen Staab</a></span> <span class="affiliation">Universität Stuttgart <span class="country">Germany</span> and University of Southampton <span class="country">UK</span></span></li>
			<li><span class="author"><a href="https://orcid.org/0000-0003-1502-6986">Antoine Zimmermann</a></span> <span class="affiliation">École des mines de Saint-Étienne <span class="country">France</span></span></li>
		</ul>
		<div class="info">
			<h2>About the book</h2>
			<p>The book is published by <a href="http://www.morganclaypool.com/">Morgan &amp; Claypool</a> in the series <a href="http://www.morganclaypool.com/toc/wbe.1/7/1">Synthesis Lectures on the Semantic Web: Theory and Technology</a> edited by <a href="http://info.slis.indiana.edu/~dingying/">Ying Ding</a> and Paul Groth. Please, cite the book as:</p>
			<blockquote class="quote">
				 Aidan Hogan, Eva Blomqvist, Michael Cochez, Claudia d’Amato, Gerard de Melo, Claudio Gutierrez, Sabrina Kirrane, José Emilio Labra Gayo, Roberto Navigli, Sebastian Neumaier, Axel-Cyrille Ngonga Ngomo, Axel Polleres, Sabbir M. Rashid, Anisa Rula, Lukas Schmelzeisen, Juan Sequeda, Steffen Staab, Antoine Zimmermann (2021) <em>Knowledge Graphs</em>, Synthesis Lectures on the Semantic Web: Theory and Technology, Vol. X, No. Y, 1-252, DOI: 10.2200/XXXXXXXXXXXXXXXXXXXXXXXXX, Morgan &amp; Claypool
			</blockquote>
			<dl>
				<dt>ISBN paperback:</dt>
				<dd>978XXXXXXXXXX</dd>
				<dt>ISBN ebook:</dt>
				<dd>9781681731650</dd>
				<dt>ISBN e-pub:</dt>
				<dd>9781681731667</dd>
			</dl>
			<p>Copyright © 2021 by Morgan &amp; Claypool. All rights reserved.</p>
			<!--<p><a href="bibtex.txt">Bibtex</a></p>-->
			<h2>Access options</h2>
			<dl>
				<dt>HTML version:</dt>
				<dd>You are currently reading the free HTML version of the book, the most recent of which is available at <a href="http://kg-book.org/">http://kg-book.org/</a></dd>
				<dt>PDF Version:</dt>
				<dd>You can download or buy the book from <a href="http://www.morganclaypool.com/">Morgan &amp; Claypool</a>. Academic and Corporate licences are available.</dd>
				<dt>Hard copy:</dt>
				<dd>You can order from from <a href="http://www.morganclaypool.com/">Morgan &amp; Claypool</a> or <a href="https://www.amazon.com/">Amazon</a>.</dd>
			</dl>
		</div>
		<!--<p><em>SYNTHESIS LECTURES ON ON THE SEMANTIC WEB #13</em></p>-->
	</header>
	<h2 id="abstract"><span>Abstract</span></h2>
	<p>
		In this paper we provide a comprehensive introduction to knowledge graphs, which have recently garnered significant attention from both industry and academia in scenarios that require exploiting diverse, dynamic, large-scale collections of data. After some opening remarks, we motivate and contrast various graph-based data models and query languages that are used for knowledge graphs. We discuss the roles of schema, identity, and context in knowledge graphs. We explain how knowledge can be represented and extracted using a combination of deductive and inductive techniques. We summarise methods for the creation, enrichment, quality assessment, refinement, and publication of knowledge graphs. We provide an overview of prominent open knowledge graphs and enterprise knowledge graphs, their applications, and how they use the aforementioned techniques. We conclude with high-level future research directions for knowledge graphs.
	</p>
	<h2 id="keywords"><span>Keywords</span></h2>
	<p>knowledge graphs, artificial intelligence, semantic web, machine learning</p>

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
$references->cite("peirce,frege,ritchens,milgram,Brachman,woods,sowa,sowa2,BrachmanS85,Schmidt-SchaussS91,berners-lee01,NavigliPonzetto:12,bollacker2007platform,suchanek2007yago,Kummel73,rada1986gradualness,Bakker,stokman1988structuring,james,Hoede95,Popping03,zhang,NurdiatiH08,rappaport1988dynamic,SrikanthJ89,de1990hybrid,MachadoR90,DiengGTC92,ShimonyDS97,JrS99,Jiang02,HelmsB05,KasneciSIRW08,ElbassuoniRSSW09,CourseyM09,PechsiriP10,CorbyF10,ciampaglia2015computational,MarchiM74,nickel,SeufertEBKBW16,BuchananF78,GuarinoOS9,rdf11sem,CormanFRS19a,BrachmanL85,sylvester");
	include("chapters/references.php");
	include("appendices/history.php");
	include("bio.php");
?>
	<h2 id="theend"><span>The End</span></h2>
</body>
</html>