	<section id="chap-deductive" class="chapter">
		<h2>Deductive Knowledge</h2>
		<p>As humans, we can <em>deduce</em> more from the data graph of Figure&nbsp;<?php echo ref("fig:delg"); ?> than what the edges explicitly indicate. We may deduce, for example, that the Ñam festival (<span class="gnode">EID15</span>) will be located in Santiago, even though the graph does not contain an edge <?php echo gedge("EID15","location","Santiago"); ?>. We may further deduce that the cities connected by flights must have some airport nearby, even though the graph does not contain nodes referring to these airports. In these cases, given the data as premises, and some general rules about the world that we may know <em>a priori</em>, we can use a deductive process to derive new data, allowing us to know more than what is explicitly given by the data. These types of general premises and rules, when shared by many people, form part of “<em>commonsense knowledge</em>”&nbsp;<?php echo $references->cite("Commonsense"); ?>; conversely, when rather shared by a few experts in an area, they form part of “<em>domain knowledge</em>”, where, for example, an expert in biology may know that <em>hemocyanin</em> is a protein containing copper that carries oxygen in the blood of some species of <em>Mollusca</em> and <em>Arthropoda</em>.</p>
		<p>Machines, in contrast, do not have <em>a priori</em> access to such deductive faculties; rather they need to be given formal instructions, in terms of premises and <em>entailment regimes</em>, facilitating similar deductions to what a human can make. In this way, we will be making more of the meaning (i.e., <em>semantics</em>) of the graph explicit in a machine-readable format. These entailment regimes formalise the conclusions that logically follow as a consequence of a given set of premises. Once instructed in this manner, machines can (often) apply deductions with a precision, efficiency, and scale beyond human performance. These deductions may serve a range of applications, such as improving query answering, (deductive) classification, finding inconsistencies, etc. As a concrete example involving query answering, assume we are interested in knowing <em>the festivals located in Santiago</em>; we may straightforwardly express such a query as per the graph pattern shown in Figure&nbsp;<?php echo ref("fig:bgpFS"); ?>. This query returns no results for the graph in Figure&nbsp;<?php echo ref("fig:delg"); ?>: there is no node named <span class="gnode">Festival</span>, and nothing has (directly) the <span class="gelab">location</span> <span class="gnode">Santiago</span>. However, an answer (<span class="gnode">Ñam</span>) could be automatically entailed were we to state that \(x\) being a Food Festival <em>entails</em> that \(x\) is a Festival, or that \(x\) having venue \(y\) in city \(z\) <em>entails</em> that \(x\) has location <span style="white-space:nowrap;">\(z\).</span> How, then, should such entailments be captured? In Section&nbsp;<?php echo ref("sec:semSchema"); ?> we already discussed how the former entailment can be captured with sub-class relations in a semantic schema; the second entailment, however, requires a more expressive entailment regime than seen thus far.</p>

		<figure id="fig-bgpFS">
			<img src="images/fig-bgpFS.svg" alt="Graph pattern querying for names of festivals in Santiago"/>
			<figcaption>Graph pattern querying for names of festivals in Santiago <a class="git" title="Consult the code for this example on Github" href="https://github.com/Knowledge-Graphs-Book/examples/blob/main/Chapter_4_Deductive_Knowledge/figure_4_1.sparql"></a></figcaption>
		</figure>

		<p>In this chapter, we discuss ways in which more complex entailments can be expressed and automated. Though we could leverage a number of logical frameworks for these purposes – such as First-Order Logic, Datalog, Prolog, Answer Set Programming, etc. – we focus on <em>ontologies</em>, which constitute a formal representation of knowledge that, importantly for us, can be represented as a graph. We then discuss how these ontologies can be formally defined, how they relate to existing logical frameworks, and how reasoning can be conducted with respect to such ontologies.</p>

		<section id="ssec-ontologies" class="section">
		<h3>Ontologies</h3>
		<p>To enable entailment, we must be precise about what the terms we use mean. Returning to Figure&nbsp;<?php echo ref("fig:delg"); ?>, for example, and examining the node <span class="gnode">EID16</span> more closely, we may begin to question how it is modelled, particularly in comparison with <span class="gnode">EID15</span>. Both nodes – according to the class hierarchy of Figure&nbsp;<?php echo ref("fig:classhier"); ?> – are considered to be events. But what if, for example, we wish to define two pairs of start and end dates for <span class="gnode">EID16</span> corresponding to the different venues? Should we rather consider what takes place in each venue as a different event? What then if an event has various start and end dates in a single venue: would these also be considered as one (recurring) event, or many events? These questions are facets of a more general question: <em>what precisely do we mean by an “event”</em>? Does it happen in one contiguous time interval or can it happen many times? Does it happen in one place or can it happen in multiple? There are no “correct” answers to such questions – we may understand the term “event” in a variety of ways, and thus the answers are a matter of <em>convention</em>.</p>
		<p>In the context of computing, an <em>ontology</em><?php echo footnote("The term stems from the philosophical study of <em>ontology</em>, concerning the kinds of entities that exist, the nature of their existence, what kinds of properties they have, and how they may be identified and categorised."); ?> is then a concrete, formal representation of what terms mean within the scope in which they are used (e.g., a given domain). For example, one event ontology may formally define that if an entity is an “event”, then it has precisely one venue and precisely one time instant in which it begins. Conversely, a different event ontology may define that an “event” can have multiple venues and multiple start times, etc. Each such ontology formally captures a particular perspective – a particular <em>convention</em>. Under the first ontology, for example, we could not call the Olympics an “event”, while under the second ontology we could. Likewise ontologies can guide how graph data are modelled. Under the first ontology we may split <span class="gnode">EID16</span> into two events. Under the second, we may elect to keep <span class="gnode">EID16</span> as one event with two venues. Ultimately, given that ontologies are formal representations, they can be used to automate entailment.</p>
		<p>Like all conventions, the usefulness of an ontology depends on the level of agreement on what that ontology defines, how detailed it is, and how broadly and consistently it is adopted. Adoption of an ontology by the parties involved in one knowledge graph may lead to a consistent use of terms and consistent modelling in that knowledge graph. Agreement over multiple knowledge graphs will, in turn, enhance the interoperability of those knowledge graphs.</p>
		<p>Amongst the most popular ontology languages used in practice are the <em>Web Ontology Language</em> (<em>OWL</em>)&nbsp;<?php echo $references->cite("OWL2"); ?><?php echo footnote("We could include RDF Schema (RDFS) in this list, but it is largely subsumed by OWL, which extends its core."); ?>, recommended by the W3C and compatible with RDF graphs; and the <em>Open Biomedical Ontologies Format</em> (<em>OBOF</em>)&nbsp;<?php echo $references->cite("obof"); ?>, used mostly in the biomedical domain. Since OWL is the more widely adopted, we focus on its features, though many similar features are found in both&nbsp;<?php echo $references->cite("obof"); ?>. Before introducing such features, however, we must discuss how graphs are to be <em>interpreted</em>.</p>

		<h4 id="sssec-interpretations" class="subsection">Interpretations and models</h4>
		<p>We as humans may <em>interpret</em> the node <span class="gnode">Santiago</span> in the data graph of Figure&nbsp;<?php echo ref("fig:delg"); ?> as referring to the real-world city that is the capital of Chile. We may further <em>interpret</em> an edge <?php echo gedge("Arica","flight","Santiago"); ?> as stating that there are flights from the city of Arica to this city. We thus interpret the data graph as another graph – what we here call the <em>domain graph</em> – composed of real-world entities connected by real-world relations. The process of interpretation, here, involves <em>mapping</em> the nodes and edges in the data graph to nodes and edges of the domain graph.</p>
		<p>Along these lines, we can abstractly define an <em>interpretation</em> of a data graph as being composed of two elements: a domain graph, and a mapping from the <em>terms</em> (nodes and edge-labels) of the data graph to those of the domain graph. The domain graph follows the same model as the data graph; for example, if the data graph is a directed edge-labelled graph, then so too will be the domain graph. For simplicity, we will speak of directed edge-labelled graphs and refer to the nodes of the domain graph as <em>entities</em>, and to its edges as <em>relations</em>. Given a data graph and an interpretation, while we denote nodes in the data graph by <span class="gnode">Santiago</span>, we will denote the entity it refers to in the domain graph by <span class="ginode">Santiago</span> (per the mapping of the given interpretation). Likewise, while we denote an edge by <?php echo gedge("Arica","flight","Santiago"); ?>, we will denote the relation by <?php echo giedge("Arica","flight","Santiago"); ?> (again, per the mapping of the given interpretation). In this abstract notion of an interpretation, we do not require that <span class="ginode">Santiago</span> or <span class="ginode">Arica</span> be the real-world cities, nor even that the domain graph contain real-world entities and relations: an interpretation can have any domain graph and mapping.</p>
		<p>Why is such an abstract notion of interpretation useful? The distinction between nodes/edges and entities/relations becomes important when we define the meaning of ontology features and entailment. To illustrate this distinction, if we ask whether there is an edge labelled <span class="gelab">flight</span> between <span class="gnode">Arica</span> and <span class="gnode">Viña&nbsp;del&nbsp;Mar</span> for the data graph in Figure&nbsp;<?php echo ref("fig:delg"); ?>, the answer is <em>no</em>. However, if we ask if the entities <span class="ginode">Arica</span> and <span class="ginode">Viña&nbsp;del&nbsp;Mar</span> are connected by the relation <span class="gielab">flight</span>, then the answer depends on what assumptions we make when interpreting the graph. Under the Closed World Assumption (CWA), if we do not have additional knowledge, then the answer is a definite <em>no</em> – since what is not known is assumed to be false. Conversely, under the Open World Assumption (OWA), we cannot be certain that this relation does not exist as this could be part of some knowledge not (yet) described by the graph. Likewise under the Unique Name Assumption (UNA), the data graph describes <em>at least two</em> flights to <span class="ginode">Santiago</span> (since <span class="ginode">Viña&nbsp;del&nbsp;Mar</span> and <span class="ginode">Arica</span> are assumed to be different entities and, therefore, <?php echo giedge("Arica","flight","Santiago"); ?> and <?php echo giedge("Viña&nbsp;del&nbsp;Mar","flight","Santiago"); ?> must be different edges). Conversely, under No Unique Name Assumption (NUNA), we can only say that there is <em>at least one</em> such flight since <span class="ginode">Viña&nbsp;del&nbsp;Mar</span> and <span class="ginode">Arica</span> may be the same entity with two “names”.</p>
		<p>These assumptions (or lack thereof) define which interpretations are valid, and which interpretations <em>satisfy</em> which data graphs. We call an interpretation that satisfies a data graph a <em>model</em> of that data graph. The UNA forbids interpretations that map two data terms to the same domain term. The NUNA allows such interpretations. Under the CWA, an interpretation that contains an edge <?php echo giedge("x","p","y"); ?> in its domain graph can only satisfy a data graph from which we can entail <?php echo gedge("x","p","y"); ?>. Under the OWA, an interpretation containing the edge <?php echo giedge("x","p","y"); ?> can satisfy a data graph not entailing <?php echo gedge("x","p","y"); ?> so long it does not explicitly contradict that edge. OWL adopts the NUNA and OWA, which is the most general case: multiple nodes/edge-labels in the graph may refer to the same entity/relation-type (per the NUNA), and anything not entailed by the data graph is <em>not</em> assumed to be false as a consequence (per the OWA).</p>

		<div class="formal">
			<p>A graph interpretation – or simply interpretation – captures the assumptions under which the semantics of a graph can be defined. We define interpretations for directed edge-labelled graphs, though the notion extends naturally to other graph models (assuming the data and domain graphs follow the same model).</p>

			<dl class="definition" id="def-graph-interpretation">
				<dt>Graph interpretation</dt>
				<dd>A <em>(graph) interpretation</em> \(I\) is defined as a pair \(I \coloneqq (\Gamma,\inp{\cdot})\) where \(\Gamma = (V_\Gamma,E_\Gamma,L_\Gamma)\) is a (directed edge-labelled) graph called the <em>domain graph</em> and \(\inp{\cdot} : \con \rightarrow V_\Gamma \cup L_\Gamma\) is a partial mapping from constants to terms in the domain graph. </dd>
			</dl>

			<p>We denote the domain of the mapping \(\inp{\cdot}\) by \(\textrm{dom}(\inp{\cdot})\). For interpretations under the UNA, the mapping \(\inp{\cdot}\) is required to be injective, while with no UNA (NUNA), no such requirement is necessary.</p>
			<p>Interpretations that <em>satisfy</em> a graph are then said to be <em>models</em> of that graph.</p>

			<dl class="definition" id="def-gmodel">
				<dt>Graph models</dt>
				<dd>Let \(G \coloneqq (V,E,L)\) be a directed edge-labelled graph. An interpretation \(I \coloneqq (\Gamma,\inp{\cdot})\) <em>satisfies</em> \(G\) if and only if the following hold:
				<ul>
					<li>\(V \cup L \subseteq \textrm{dom}(\inp{\cdot})\);</li>
					<li>for all \(v \in V\), it holds that \(\inp{v} \in V_\Gamma\);</li>
					<li>for all \(l \in L\), it holds that \(\inp{l} \in L_\Gamma\); and</li>
					<li>for all \((u,l,v) \in E\), it holds that \((\inp{u},\inp{l},\inp{v}) \in E_\Gamma\).</li>
				</ul>
				If \(I\) <em>satisfies</em> \(G\) we call \(I\) a <em>(graph) model</em> of \(G\).</dd>
			</dl>
		</div>

		<h4 id="ssec-ontology-features" class="subsection">Ontology features</h4>
		<p>Beyond our base assumptions, we can associate certain patterns in the data graph with <em>semantic conditions</em> that define which interpretations satisfy it; for example, we can add a semantic condition to enforce that if our data graph contains the edge <?php echo gedge("p","subp.&nbsp;of","q"); ?>, then any edge <?php echo giedge("x","p","y"); ?> in the domain graph of the interpretation must also have a corresponding edge <?php echo giedge("x","q","y"); ?> to satisfy the data graph. These semantic conditions then form the features of an ontology language. In what follows, to aid readability, we will introduce the features of OWL using an abstract graphical notation with abbreviated terms. For details of concrete syntaxes, we rather refer to the OWL and OBOF standards&nbsp;<?php echo $references->cite("OWL2,obof"); ?>. Likewise we present semantic conditions over interpretations for each feature in the same graphical format;<?php echo footnote("We abbreviate “if and only if” as “iff” whereby “\\(\\phi\\) iff \\(\\psi\\)” can be read as <span style=\"white-space:nowrap;\">“if \\(\\phi\\) then \\(\\psi\\)”</span> and “if \\(\\psi\\) then \\(\\phi\\)”."); ?> further details of these conditions will be described later in Section&nbsp;<?php echo ref("sec:ontSemantics"); ?>.</p>

		<h5 id="sssec-individuals" class="subsubsection">Individuals</h5>
		<p>In Table&nbsp;<?php echo ref("tab:ontEqIneq"); ?>, we list the main features supported by OWL for describing <em>individuals</em> (e.g., <span class="sf">Santiago</span>, <span class="sf">EID16</span>), sometimes distinguished from classes and properties. First, we can <em>assert</em> (binary) relations between individuals using edges such as <?php echo gedge("Santa&nbsp;Lucía","city","Santiago"); ?>. In the condition column, when we write <?php echo giedge("\\(x\\)","\\(y\\)","\\(z\\)"); ?>, for example, we refer to the condition that the relation is given in the domain graph of the interpretation; if so, the interpretation satisfies the axiom. OWL further allows for defining relations to explicitly state that two terms refer to the <em>same</em> entity, where, e.g., <?php echo gedge("Región&nbsp;V","same&nbsp;as","Región de Valparaíso"); ?> states that both refer to the same region (per Section&nbsp;<?php echo ref("sec:identity"); ?>); or that two terms refer to <em>different</em> entities, where, e.g., <?php echo gedge("Valparaíso","diff.&nbsp;from","Región&nbsp;de&nbsp;Valparaíso"); ?> distinguishes the city from the region of the same name. We may also state that a relation does not hold using <em>negation</em>, which can be serialised as a graph using a form of reification (see Figure&nbsp;<?php echo ref("fig:reif"); ?>).</p>

		<table class="normalTable" id="tab-ontEqIneq">
			<caption>Ontology features for individuals <a class="git" title="Consult the code for this example on Github" href="https://github.com/Knowledge-Graphs-Book/examples/blob/main/Chapter_4_Deductive_Knowledge/4_1_2_Ontology_features/table_4_1.ttl"></a></caption>
			<thead>
				<tr>
					<th>Feature</th>
					<th>Axiom</th>
					<th>Condition</th>
					<th>Example</th>
				</tr>
			</thead>
			<tbody>
				<tr>
					<td>Assertion</td>
					<td><?php echo gedge("\\(x\\)","\\(y\\)","\\(z\\)"); ?></td>
					<td><?php echo giedge("\\(x\\)","\\(y\\)","\\(z\\)"); ?></td>
					<td><?php echo gedge("Chile","capital","Santiago"); ?></td>
				</tr>
				<tr>
					<td>Negation</td>
					<td><img class="inside" src="images/tab-ontEqIneq-neg-axiom.svg" alt="negation axiom" /></td>
					<td>not <?php echo giedge("\\(x\\)","\\(y\\)","\\(z\\)"); ?></td>
					<td><img class="inside" src="images/tab-ontEqIneq-neg-example.svg" alt="negation example" /></td>
				</tr>
				<tr>
					<td>Same As</td>
					<td><?php echo gedge("\\(x_1\\)","same&nbsp;as","\\(x_2\\)"); ?></td>
					<td><span class="ginode">\(x_1\)</span> = <span class="ginode">\(x_2\)</span></td>
					<td><?php echo gedge("Región&nbsp;V","same&nbsp;as","Región&nbsp;de&nbsp;Valparaíso"); ?></td>
				</tr>
				<tr>
					<td>Different From</td>
					<td><?php echo gedge("\\(x_1\\)","diff.&nbsp;from","\\(x_2\\)"); ?></td>
					<td><span class="ginode">\(x_1\)</span> ≠ <span class="ginode">\(x_2\)</span></td>
					<td><?php echo gedge("Valparaíso","diff.&nbsp;from","Región&nbsp;de&nbsp;Valparaíso"); ?></td>
				</tr>
			</tbody>
		</table>

		<h5 id="sssec-properties" class="subsubsection">Properties</h5>
		<p>In Section&nbsp;<?php echo ref("sec:semSchema"); ?>, we already discussed how <em>sub-properties</em>, <em>domains</em> and <em>ranges</em> may be defined for properties. OWL allows such definitions, and further includes other features, as listed in Table&nbsp;<?php echo ref("tab:ontProp"); ?>. We may define a pair of properties to be <em>equivalent</em>, <em>inverses</em>, or <em>disjoint</em>. We can further define a particular property to denote a <em>transitive</em>, <em>symmetric</em>, <em>asymmetric</em>, <em>reflexive</em>, or <em>irreflexive</em> relation. We can also define the multiplicity of the relation denoted by properties, based on being <em>functional</em> (many-to-one) or <em>inverse-functional</em> (one-to-many). We may further define a <em>key</em> for a class, denoting the set of properties whose values uniquely identify the entities of that class. Without adopting a Unique Name Assumption (UNA), from these latter three features we may conclude that two or more terms refer to the same entity. Finally, we can relate a property to a <em>chain</em> (a path expression only allowing concatenation of properties) such that pairs of entities related by the chain are also related by the given property. Note that for the latter two features in Table&nbsp;<?php echo ref("tab:ontProp"); ?> we require representing a list, denoted with a vertical notation <span class="gnode">⋮</span>; while such a list may be serialised as a graph in a number of concrete ways, OWL uses RDF lists (see Figure&nbsp;<?php echo ref("fig:list"); ?>).</p>

		<table class="normalTable" id="tab-ontProp">
			<caption>Ontology features for property axioms <a class="git" title="Consult the code for this example on Github" href="https://github.com/Knowledge-Graphs-Book/examples/blob/main/Chapter_4_Deductive_Knowledge/4_1_2_Ontology_features/table_4_2.ttl"></a></caption>
			<thead>
				<tr>
					<th>Feature</th>
					<th>Axiom</th>
					<th>Condition <span style="font-weight: normal">(for all \(x_*\), \(y_*\), \(z_*\))</span></th>
					<th>Example</th>
				</tr>
			</thead>
			<tbody>
				<tr>
					<td>Sub-property</td>
					<td><?php echo gedge("\\(p\\)","subp.&nbsp;of","\\(q\\)"); ?></td>
					<td><?php echo giedge("\\(x\\)","\\(p\\)","\\(y\\)"); ?> implies <?php echo giedge("\\(x\\)","\\(q\\)","\\(y\\)"); ?></td>
					<td><?php echo gedge("venue","subp.&nbsp;of","location"); ?></td>
				</tr>
				<tr>
					<td>Domain</td>
					<td><?php echo gedge("\\(p\\)","domain","\\(c\\)"); ?></td>
					<td><?php echo giedge("\\(x\\)","\\(p\\)","\\(y\\)"); ?> implies <?php echo giedge("\\(x\\)","type","\\(c\\)"); ?></td>
					<td><?php echo gedge("venue","domain","Event"); ?></td>
				</tr>
				<tr>
					<td>Range</td>
					<td><?php echo gedge("\\(p\\)","range","\\(c\\)"); ?></td>
					<td><?php echo giedge("\\(x\\)","\\(p\\)","\\(y\\)"); ?> implies <?php echo giedge("\\(y\\)","type","\\(c\\)"); ?></td>
					<td><?php echo gedge("venue","range","Venue"); ?></td>
				</tr>
				<tr>
					<td>Equivalence</td>
					<td><?php echo gedge("\\(p\\)","equiv.&nbsp;p.","\\(q\\)"); ?></td>
					<td><?php echo giedge("\\(x\\)","\\(p\\)","\\(y\\)"); ?> iff <?php echo giedge("\\(x\\)","\\(q\\)","\\(y\\)"); ?></td>
					<td><?php echo gedge("start","equiv.&nbsp;p.","begins"); ?></td>
				</tr>
				<tr>
					<td>Inverse</td>
					<td><?php echo gedge("\\(p\\)","inv.&nbsp;of","\\(q\\)"); ?></td>
					<td><?php echo giedge("\\(x\\)","\\(p\\)","\\(y\\)"); ?> iff <?php echo giedge("\\(y\\)","\\(q\\)","\\(x\\)"); ?></td>
					<td><?php echo gedge("venue","inv.&nbsp;of","hosts"); ?></td>
				</tr>
				<tr>
					<td>Disjoint</td>
					<td><?php echo gedge("\\(p\\)","disj.&nbsp;p.","\\(q\\)"); ?></td>
					<td>not <img class="inside" src="images/tab-ontProp-disj-cond.svg" alt="disjoint condition" /></td>
					<td><?php echo gedge("venue","disj.&nbsp;p.","hosts"); ?></td>
				</tr>
				<tr>
					<td>Transitive</td>
					<td><?php echo gedge("\\(p\\)","type","Transitive"); ?></td>
					<td><?php echo giedge("\\(x\\)","\\(p\\)","\\(y\\)"); ?><?php echo isource(); ?><span class="iedge">\(p\)</span><?php echo itipr(); ?><span class="ginode">\(z\)</span><br/>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; implies <?php echo giedge("\\(x\\)","\\(p\\)","\\(z\\)"); ?></td>
					<td><?php echo gedge("part&nbsp;of","type","Transitive"); ?></td>
				</tr>
				<tr>
					<td>Symmetric</td>
					<td><?php echo gedge("\\(p\\)","type","Symmetric"); ?></td>
					<td><?php echo giedge("\\(x\\)","\\(p\\)","\\(y\\)"); ?> iff <?php echo giedge("\\(y\\)","\\(p\\)","\\(x\\)"); ?></td>
					<td><?php echo gedge("nearby","type","Symmetric"); ?></td>
				</tr>
				<tr>
					<td>Asymmetric</td>
					<td><?php echo gedge("\\(p\\)","type","Asymmetric"); ?></td>
					<td>not <img class="inside" src="images/tab-ontProp-asym-cond.svg" alt="asymmetric condition" /></td>
					<td><?php echo gedge("capital","type","Asymmetric"); ?></td>
				</tr>
				<tr>
					<td>Reflexive</td>
					<td><?php echo gedge("\\(p\\)","type","Reflexive"); ?></td>
					<td><img class="inside" src="images/tab-ontProp-refl-cond.svg" alt="reflexive condition" /></td>
					<td><?php echo gedge("part&nbsp;of","type","Reflexive"); ?></td>
				</tr>
				<tr>
					<td>Irreflexive</td>
					<td><?php echo gedge("\\(p\\)","type","Irreflexive"); ?></td>
					<td>not <img class="inside" src="images/tab-ontProp-refl-cond.svg" alt="irreflexive condition" /></td>
					<td><?php echo gedge("flight","type","Irreflexive"); ?></td>
				</tr>
				<tr>
					<td>Functional</td>
					<td><?php echo gedge("\\(p\\)","type","Functional"); ?></td>
					<td><span class="ginode">\(y_1\)</span><?php echo itipl(); ?><span class="iedge">\(p\)</span><?php echo isource(); ?><?php echo giedge("\\(x\\)","\\(p\\)","\\(y_2\\)"); ?><br/>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; implies <span class="ginode">\(y_1\)</span> = <span class="ginode">\(y_2\)</span></td>
					<td><?php echo gedge("population","type","Functional"); ?></td>
				</tr>
				<tr>
					<td>Inv. Functional</td>
					<td><?php echo gedge("\\(p\\)","type","Inv.&nbsp;Functional"); ?></td>
					<td><?php echo giedge("\\(x_1\\)","\\(p\\)","\\(y\\)"); ?><?php echo itipl(); ?><span class="iedge">\(p\)</span><?php echo isource(); ?><span class="ginode">\(x_2\)</span><br/>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; implies <span class="ginode">\(x_1\)</span> = <span class="ginode">\(x_2\)</span></td>
					<td><?php echo gedge("capital","type","Inv.&nbsp;Functional"); ?></td>
				</tr>
				<tr>
					<td>Key</td>
					<td><span class="gnode">\(c\)</span><?php echo esource(); ?><span class="edge">key</span><?php echo etipr(); ?><span class="gnode stack-tab">\(p_1\)<br/>⋮<br/>\(p_n\)</span></td>
					<td><img style="margin-left:0;" class="inside" src="images/tab-ontProp-key-cond.svg" alt="key condition premise" />&thinsp;implies&thinsp;<span class="ginode">\(x_1\)</span>=<span class="ginode">\(x_2\)</span></td>
					<td><span class="gnode">City</span><?php echo esource(); ?><span class="edge">key</span><?php echo etipr(); ?><span class="gnode stack-tab">lat<br/>long</span></td>
				</tr>
				<tr>
					<td>Chain</td>
					<td><span class="gnode">\(p\)</span><?php echo esource(); ?><span class="edge">chain</span><?php echo etipr(); ?><span class="gnode stack-tab">\(q_1\)<br/>⋮<br/>\(q_n\)</span></td>
					<td><?php echo giedge("\\(x\\)","\\(q_1\\)","\\(y_1\\)"); ?><?php echo isource(); ?>…<?php echo itipr(); ?><?php echo giedge("\\(y_{n-1}\\)","\\(q_n\\)","\\(z\\)"); ?><br/>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; implies <?php echo giedge("\\(x\\)","\\(p\\)","\\(z\\)"); ?></td>
					<td><span class="gnode">location</span><?php echo esource(); ?><span class="edge">chain</span><?php echo etipr(); ?><span class="gnode stack-tab">location<br/>part&nbsp;of</span></td>
				</tr>
			</tbody>
		</table>

		<h5 id="sssec-classes" class="subsubsection">Classes</h5>
		<p>In Section&nbsp;<?php echo ref("sec:semSchema"); ?>, we discussed how class hierarchies can be modelled using a <em>sub-class</em> relation. OWL supports sub-classes, and many additional features, for defining and making claims about classes; these additional features are summarised in Table&nbsp;<?php echo ref("tab:ontClass"); ?>. Given a pair of classes, OWL allows for defining that they are <em>equivalent</em>, or <em>disjoint</em>. Thereafter, OWL provides a variety of features for defining novel classes by applying set operators on other classes, or based on conditions that the properties of its instances satisfy. First, using set operators, one can define a novel class as the <em>complement</em> of another class, the <em>union</em> or <em>intersection</em> of a list (of arbitrary length) of other classes, or as an <em>enumeration</em> of all of its instances. Second, by placing restrictions on a particular property \(p\), one can define classes whose instances are all of the entities that have: <em>some value</em> from a given class on \(p\); <em>all values</em> from a given class on \(p\);<?php echo footnote("While something like <span class=\"gnode\">flight</span>". etipl() ."<span class=\"edge\">prop</span>". esource() . gedge("DomesticAirport","all","NationalFlight") ." might appear to be a more natural example for <span class=\"sc\">All Values</span>, this would be problematic as the corresponding <em>for all</em> condition is satisfied when no such node exists, so we would infer anything known not to have any flights to be a domestic airport. (We could, however, define the intersection of such a definition and airport as being a domestic airport.)"); ?> have a specific individual as a value on \(p\) (<em>has value</em>); have themselves as a reflexive value on \(p\) (<em>has self</em>); have at least, at most or exactly some number of values on \(p\) (<em>cardinality</em>); and have at least, at most or exactly some number of values on \(p\) from a given class (<em>qualified cardinality</em>). For the latter two cases, in Table&nbsp;<?php echo ref("tab:ontClass"); ?>, we use the notation “\(\#\{\)<span class="ginode">a</span>\(\mid \phi \}\)” to count distinct entities satisfying \(\phi\) in the interpretation. These features can then be combined to create more complex classes, where combining the examples for <span class="sc">Intersection</span> and <span class="sc">Has Self</span> in Table&nbsp;<?php echo ref("tab:ontClass"); ?> gives the definition: <em>self-driving taxis are taxis having themselves as a driver</em>.</p>

		<table class="normalTable" id="tab-ontClass">
			<caption>Ontology features for class axioms and definitions <a class="git" title="Consult the code for this example on Github" href="https://github.com/Knowledge-Graphs-Book/examples/blob/main/Chapter_4_Deductive_Knowledge/4_1_2_Ontology_features/table_4_3.ttl"></a></caption>
			<thead>
				<tr>
					<th>Feature</th>
					<th>Axiom</th>
					<th>Condition <span style="font-weight: normal">(for all \(x_*\), \(y_*\), \(z_*\))</span></th>
					<th>Example</th>
				</tr>
			</thead>
			<tbody>
				<tr>
					<td>Sub-class</td>
					<td><?php echo gedge("\\(c\\)","subc.&nbsp;of","\\(d\\)"); ?></td>
					<td><?php echo giedge("\\(x\\)","type","\\(c\\)"); ?> implies <?php echo giedge("\\(x\\)","type","\\(d\\)"); ?></td>
					<td><?php echo gedge("City","subc.&nbsp;of","Place"); ?></td>
				</tr>
				<tr>
					<td>Equivalence</td>
					<td><?php echo gedge("\\(c\\)","equiv.&nbsp;c.","\\(d\\)"); ?></td>
					<td><?php echo giedge("\\(x\\)","type","\\(c\\)"); ?> iff <?php echo giedge("\\(x\\)","type","\\(d\\)"); ?></td>
					<td><?php echo gedge("Human","equiv.&nbsp;of","Person"); ?></td>
				</tr>
				<tr>
					<td>Disjoint</td>
					<td><?php echo gedge("\\(c\\)","disj.&nbsp;c.","\\(d\\)"); ?></td>
					<td>not <span class="ginode">\(c\)</span><?php echo itipl(); ?><span class="iedge">type</span><?php echo isource(); ?><?php echo giedge("\\(x\\)","type","\\(d\\)"); ?></td>
					<td><?php echo gedge("City","disj.&nbsp;c.","Region"); ?></td>
				</tr>
				<tr>
					<td>Complement</td>
					<td><?php echo gedge("\\(c\\)","comp.","\\(d\\)"); ?></td>
					<td><?php echo giedge("\\(x\\)","type","\\(c\\)"); ?> iff not <?php echo giedge("\\(x\\)","type","\\(d\\)"); ?></td>
					<td><?php echo gedge("Dead","comp.","Alive"); ?></td>
				</tr>
				<tr>
					<td>Union</td>
					<td><span class="gnode">\(c\)</span><?php echo esource(); ?><span class="edge">union</span><?php echo etipr(); ?><span class="gnode stack-tab">\(d_1\)<br/>⋮<br/>\(d_n\)</span></td>
					<td><?php echo giedge("\\(x\\)","type","\\(c\\)"); ?> iff <div class="stack-tab"><?php echo giedge("\\(x\\)","type","\\(d_1\\)"); ?> or<br/><?php echo giedge("\\(x\\)","type","…"); ?> or<br/><?php echo giedge("\\(x\\)","type","\\(d_n\\)"); ?></div></td>
					<td><span class="gnode">Flight</span><?php echo esource(); ?><span class="edge">union</span><?php echo etipr(); ?><span class="gnode stack-tab">DomesticFlight<br/>InternationalFlight</span></td>
				</tr>
				<tr>
					<td>Intersection</td>
					<td><span class="gnode">\(c\)</span><?php echo esource(); ?><span class="edge">inter.</span><?php echo etipr(); ?><span class="gnode stack-tab">\(d_1\)<br/>⋮<br/>\(d_n\)</span></td>
					<td><?php echo giedge("\\(x\\)","type","\\(c\\)"); ?> iff <img class="inside" src="images/tab-ontClass-inter-cond.svg" alt="intersection condition equiv" /></td>
					<td><span class="gnode">SelfDrivingTaxi</span><?php echo esource(); ?><span class="edge">inter.</span><?php echo etipr(); ?><span class="gnode stack-tab">Taxi<br/>SelfDriving</span></td>
				</tr>
				<tr>
					<td>Enumeration</td>
					<td><span class="gnode">\(c\)</span><?php echo esource(); ?><span class="edge">one&nbsp;of</span><?php echo etipr(); ?><span class="gnode stack-tab">\(x_1\)<br/>⋮<br/>\(x_n\)</span></td>
					<td><?php echo giedge("\\(x\\)","type","\\(c\\)"); ?> iff <span class="ginode">\(x\)</span> \(\in \{\)<span class="ginode">\(x_1\)</span>\(,\dots,\)<span class="ginode">\(x_n\)</span>\(\}\)</td>
					<td><span class="gnode">EUState</span><?php echo esource(); ?><span class="edge">one&nbsp;of</span><?php echo etipr(); ?><span class="gnode stack-tab">Austria<br/>⋮<br/>Sweden</span></td>
				</tr>
				<tr>
					<td>Some Values</td>
					<td><img class="inside" src="images/tab-ontClass-someval-axiom.svg" alt="some values axiom" /></td>
					<td><?php echo giedge("\\(x\\)","type","\\(c\\)"); ?> iff <div class="stack-tab">there exists <span class="ginode">\(a\)</span> such that<br/><?php echo giedge("\\(x\\)","\\(p\\)","\\(a\\)"); ?><?php echo isource(); ?><span class="iedge">type</span><?php echo itipr(); ?><span class="ginode">\(d\)</span></div></td>
					<td><img class="inside" src="images/tab-ontClass-someval-example.svg" alt="some values example" /></td>
				</tr>
				<tr>
					<td>All Values</td>
					<td><img class="inside" src="images/tab-ontClass-allval-axiom.svg" alt="all values axiom" /></td>
					<td><?php echo giedge("\\(x\\)","type","\\(c\\)"); ?> iff <div class="stack-tab">for all <span class="ginode">\(a\)</span> with <?php echo giedge("\\(x\\)","\\(p\\)","\\(a\\)"); ?><br/>it holds that <?php echo giedge("\\(a\\)","type","\\(d\\)"); ?></div></td>
					<td><img class="inside" src="images/tab-ontClass-allval-example.svg" alt="all values example" /></td>
				</tr>
				<tr>
					<td>Has Value</td>
					<td><img class="inside" src="images/tab-ontClass-hasval-axiom.svg" alt="has value axiom" /></td>
					<td><?php echo giedge("\\(x\\)","type","\\(c\\)"); ?> iff <?php echo giedge("\\(x\\)","\\(p\\)","\\(y\\)"); ?></td>
					<td><img class="inside" src="images/tab-ontClass-hasval-example.svg" alt="has value example" /></td>
				</tr>
				<tr>
					<td>Has Self</td>
					<td><img class="inside" src="images/tab-ontClass-hasself-axiom.svg" alt="has self axiom" /></td>
					<td><?php echo giedge("\\(x\\)","type","\\(c\\)"); ?> iff <?php echo giedge("\\(x\\)","\\(p\\)","\\(x\\)"); ?></td>
					<td><img class="inside" src="images/tab-ontClass-hasself-example.svg" alt="has self example" /></td>
				</tr>
				<tr>
					<td>Cardinality<br/>\(\star \in \{ =, \leq, \geq \}\)</td>
					<td><img class="inside" src="images/tab-ontClass-card-axiom.svg" alt="cardinality axiom" /></td>
					<td><?php echo giedge("\\(x\\)","type","\\(c\\)"); ?><br/>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; iff \(\#\{\)<span class="ginode">a</span> \(\mid\) <?php echo giedge("\\(x\\)","\\(p\\)","\\(a\\)"); ?>\(\} \star n\)</td>
					<td><img class="inside" src="images/tab-ontClass-card-example.svg" alt="cardinality example" /></td>
				</tr>
				<tr>
					<td>Qualified<br/>Cardinality<br/>\(\star \in \{ =, \leq, \geq \}\)</td>
					<td><img class="inside" src="images/tab-ontClass-qualcard-axiom.svg" alt="qualified cardinality axiom" /></td>
					<td><?php echo giedge("\\(x\\)","type","\\(c\\)"); ?><br/>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; iff \(\#\{\)<span class="ginode">a</span> \(\mid\) <?php echo giedge("\\(x\\)","\\(p\\)","\\(a\\)"); ?><?php echo isource(); ?><span class="iedge">type</span><?php echo itipr(); ?><span class="ginode">\(d\)</span>\(\} \star n\)</td>
					<td><img class="inside" src="images/tab-ontClass-qualcard-example.svg" alt="qualified cardinality example" /></td>
				</tr>
			</tbody>
		</table>

		<h5 id="sssec-other-features" class="subsubsection">Other features</h5>
		<p>OWL supports other language features not previously discussed, including: <em>annotation properties</em>, which provide metadata about ontologies, such as versioning info; <em>datatype vs.&nbsp;object properties</em>, which distinguish properties that take datatype values from those that do not; and <em>datatype facets</em>, which allow for defining new datatypes by applying restrictions to existing datatypes, such as to define that places in Chile must have a <em>float between \(-66.0\) and \(-110.0\)</em> as their value for the (datatype) property <span class="gelab">latitude</span>. For more details we refer to the OWL 2 standard&nbsp;<?php echo $references->cite("OWL2"); ?>. We will further discuss methodologies for the creation of ontologies in Section&nbsp;<?php echo ref("ssec:knowledgeConceptual"); ?>.</p>

		<h5 id="sssec-modesl-under-semantic-conditions" class="subsubsection">Models under semantic conditions</h5>
		<p>Each axiom described by the previous tables, when added to a graph, enforces some condition(s) on the models the graph. If we were to consider only the base condition of the <span class="sc">Assertion</span> feature in Table&nbsp;<?php echo ref("tab:ontEqIneq"); ?>, for example, then the models of a graph would be any interpretation such that for every edge <?php echo gedge("x","y","z"); ?> in the graph, there exists a relation <?php echo giedge("x","y","z"); ?> in the model. Given that there may be other relations in the model (under the OWA), the number of models of any such graph is infinite. Furthermore, given that we can map multiple nodes in the graph to one entity in the model (under the NUNA), any interpretation with (for example) the relation <?php echo giedge("a","a","a"); ?> is a model of any graph so long as for every edge <?php echo gedge("x","y","z"); ?> in the graph, it holds that <span class="ginode">x</span> = <span class="ginode">y</span> = <span class="ginode">z</span> = <span class="ginode">a</span> in the interpretation (in other words, the interpretation maps everything to <span class="ginode">a</span>). As we add axioms with their associated conditions to the graph, we restrict models for the graph; for example, considering a graph with two edges – <?php echo gedge("x","y","z"); ?> and <?php echo gedge("y","type","Irreflexive"); ?> – the interpretation with <?php echo giedge("a","a","a"); ?>, <span class="ginode">x</span> = <span class="ginode">y</span> = … = <span class="ginode">a</span> is no longer a model as it breaks the condition for the irreflexive axiom. In this way, we can define a precise model-theoretic semantics for graphs based on how the aforementioned ontological features used in the graph restrict the models of that graph.</p>

		<div class="formal">
			<p>We define models under semantics conditions.</p>

			<dl class="definition" id="def-semantic-condition">
				<dt>Semantic condition</dt>
				<dd>Let \(2^G\) denote the set of all (directed edge-labelled) graphs. A <em>semantic condition</em> is a mapping \(\phi : 2^{G} \rightarrow \{ \text{true}, \text{false} \}\). An interpretation \(I \coloneqq (\Gamma,\inp{\cdot})\) is a model of \(G\) under \(\phi\) if and only if \(I\) is a model of \(G\) and \(\phi(\Gamma)\). Given a set of semantic conditions \(\Phi\), we say that \(I\) is a model of \(G\) if and only if \(I\) is a model of \(G\) and for all \(\phi \in \Phi\), \(\phi(\Gamma)\) is true.</dd>
			</dl>

			<p>We do not restrict the language used to define semantic conditions, but, for example, we can define the <span class="sc">Has Value</span> semantic condition of Table&nbsp;<?php echo ref("tab:ontClass"); ?> in FOL as:</p>
			<p class="mathblock">\(\forall c, p, y \Big( \big( \Gamma(c,\)<span class="gelab">prop</span>\(,p) \wedge \Gamma(c,\)<span class="gelab">value</span>\(,y) \big) \leftrightarrow \forall x \big( \Gamma(x,\)<span class="gelab">type</span>\(,c) \leftrightarrow \Gamma(x,p,y) \big) \Big)\)</p>
			<p>Here we overload \(\Gamma\) as a ternary predicate to capture the edges of \(\Gamma\). The other semantic conditions enumerated in Tables&nbsp;<?php echo ref("tab:ontEqIneq"); ?>–<?php echo ref("tab:ontClass"); ?> can be defined in a similar way&nbsp;<?php echo $references->cite("SchneiderS11"); ?>.<?php echo footnote("Although these tables consider axioms originating in the data graph, it suffices to check their image in the domain graph since \\(I\\) only satisfies \\(G\\) if the edges of \\(G\\) defining the axioms are reflected in the domain graph of \\(I\\) per Definition&nbsp;". ref("def:gmodel") .". This then simplifies the definitions considerably."); ?> This FOL formula defines an if-and-only-if version of the semantic condition for <span class="sc">Has Value</span> (described in Section&nbsp;<?php echo ref("sec:iff"); ?>).</p>
		</div>
		
		<h4 id="sec-ontSemantics" class="subsection">Entailment</h4>
		<p>The conditions listed in the previous tables give rise to <em>entailments</em>, where, for example, in reference to the <span class="sc">Symmetric</span> feature of Table&nbsp;<?php echo ref("tab:ontProp"); ?>, the definition <?php echo gedge("nearby","type","Symmetric"); ?> and edge <?php echo gedge("Santiago","nearby","Santiago&nbsp;Airport"); ?> entail the edge <?php echo gedge("Santiago&nbsp;Airport","nearby","Santiago"); ?> according to the condition given for that feature. We now describe how these conditions lead to entailments.</p>
		<p>We say that one graph <em>entails</em> another if and only if any model of the former graph is also a model of the latter graph. Intuitively this means that the latter graph says nothing new over the former graph and thus holds as a logical consequence of the former graph. For example, consider the graph <?php echo gedge("Santiago","type","City"); ?><?php echo esource(); ?><span class="edge">subc.&nbsp;of</span><?php echo etipr(); ?><span class="gnode">Place</span> and the graph <?php echo gedge("Santiago","type","Place"); ?>. All models of the latter must have that <?php echo giedge("Santiago","type","Place"); ?>, but so must all models of the former, which must have <?php echo giedge("Santiago","type","City"); ?><?php echo isource(); ?><span class="iedge">subc.&nbsp;of</span><?php echo itipr(); ?><span class="ginode">Place</span> and further must satisfy the condition for <span class="sc">Sub-class</span>, which requires that <?php echo giedge("Santiago","type","Place"); ?> also hold. Hence we conclude that any model of the former graph must be a model of the latter graph, or, in other words, the former graph entails the latter graph.</p>

		<div class="formal">
			<p>We now formally define entailment under semantic conditions.</p>

			<dl class="definition" id="def-ent">
				<dt>Graph entailment</dt>
				<dd>Letting \(G_1\) and \(G_2\) denote two (directed edge-labelled) graphs, and \(\Phi\) a set of semantic conditions, we say that <em>\(G_1\) entails \(G_2\) under \(\Phi\)</em> – denoted \(G_1 \models_\Phi G_2\) – if and only if any model of \(G_1\) under \(\Phi\) is also a model of \(G_2\) under \(\Phi\).</dd>
			</dl>

			<p>An example of entailment is discussed in Section&nbsp;<?php echo ref("sec:ontSemantics"); ?>.<?php echo footnote("Here we have defined entailment under OWA. To define entailment under CWA, let \\(G \\models_\\Phi (s,p,o)\\) denote that \\(G\\) entails the edge \\((s,p,o)\\) under \\(\\Phi\\) (a slight abuse of notation). Under CWA, we make the additional assumption that if \\(G \\not\\models_\\Phi e\\), where \\(e\\) is an edge (strictly speaking, a <em>positive</em> edge), then \\(G \\models_\\Phi \\neg e\\); in other words, under CWA we assume that any (positive) edges that \\(G\\) does not entail under \\(\\Phi\\) can be assumed false according to \\(G\\) and \\(\\Phi\\). However, note that in FOL, the CWA only applies to positive <em>facts</em>, whereas edges in a graph can be used to represent other FOL formulae. If one wished to maintain FOL-compatibility under CWA, additional restrictions on the types of edge \\(e\\) may be needed."); ?></p>
		</div>

		<h4 id="sec-iff" class="subsection">If–then vs. if-and-only-if semantics</h4>
		<p>Consider the graph <?php echo gedge("nearby","type","Symmetric"); ?> and the graph <?php echo gedge("nearby","inv.&nbsp;of","nearby"); ?>. Both of these graphs result in the same semantic conditions being applied in the domain graph, but does one entail the other? The answer depends on the semantics applied. Considering the axioms and conditions of Tables&nbsp;<?php echo ref("tab:ontEqIneq"); ?>, we can consider two semantics. Under <em>if</em>–<em>then</em> semantics – <em>if</em> <strong>Axiom</strong> matches the data graph <em>then</em> <strong>Condition</strong> holds in domain graph – the graphs do not entail each other: though both graphs give rise to the same condition, this condition is not translated back into the axioms that describe it.<?php echo footnote("Here, ".giedge("nearby","type","Symmetric") ." is a model of the first graph but not the second, while ". giedge("nearby","inv.&nbsp;of","nearby") ." is a model of the second graph but not the first. Hence neither graph entails the other."); ?> Conversely, under <em>if-and-only-if</em> semantics – <strong>Axiom</strong> matches data graph <em>if-and-only-if</em> <strong>Condition</strong> holds in domain graph – the graphs entail each other: both graphs give rise to the same condition, which is translated back into all possible axioms that describe it. Hence if-and-only-if semantics allows for entailing more axioms in the ontology language than if–then semantics. OWL generally applies an if-and-only-if semantics in order to enable richer entailments&nbsp;<?php echo $references->cite("OWL2"); ?>.</p>
		</section>

		<section id="ssec-reasoning" class="section">
		<h3>Reasoning</h3>
		<p>Unfortunately, given two graphs, deciding if the first entails the second – per the notion of entailment we have defined and for all of the ontological features listed in Tables&nbsp;<?php echo ref("tab:ontEqIneq"). "–" .ref("tab:ontClass"); ?> – is <em>undecidable</em>: no (finite) algorithm for such entailment can exist that halts on all inputs with the correct <code>true</code>/<code>false</code> answer&nbsp;<?php echo $references->cite("Hitzler2010"); ?>. However, we can provide practical reasoning algorithms for ontologies that (1) halt on any pair of input ontologies but may miss entailments, returning <code>false</code> instead of <code>true</code> in some cases, (2) always halt with the correct answer but only accept input ontologies with restricted features, or (3) only return correct answers for any pair of input ontologies but may never halt on certain inputs. Though option (3) has been explored using, e.g., theorem provers for First Order Logic (FOL)&nbsp;<?php echo $references->cite("SchneiderS11"); ?>, options (1) and (2) are more commonly pursued using rules and/or Description Logics. Option (1) generally allows for more efficient and scalable reasoning algorithms and is useful where data are incomplete and having some entailments is valuable. Option (2) may be a better choice in domains – such as medical ontologies – where missing entailments may have undesirable outcomes.</p>

		<h4 id="sec-rules" class="subsection">Rules</h4>
		<p>A straightforward way to provide automated access to the knowledge that can be deduced through (ontological or other forms of) entailments is through <em>inference rules</em> (or simply <em>rules</em>) encoding <span class="sc">if</span>–<span class="sc">then</span>-style consequences. A rule is composed of a <em>body</em> (<span class="sc">if</span>) and a <em>head</em> (<span class="sc">then</span>). Both the body and head are given as graph patterns. A rule indicates that if we can replace the variables of the body with terms from the data graph and form a sub-graph of a given data graph, then using the same replacement of variables in the head will yield a valid entailment. The head must typically use a subset of the variables appearing in the body to ensure that the conclusion leaves no variables unreplaced. Rules of this form correspond to (positive) Datalog&nbsp;<?php echo $references->cite("CeriGT89"); ?> in Databases, Horn clauses&nbsp;<?php echo $references->cite("lloyd2012foundations"); ?> in Logic Programming, etc.</p>
		<p>Rules can capture entailments under ontological conditions. In Table&nbsp;<?php echo ref("tab:rulesRdfs"); ?>, we list some example rules for sub-class, sub-property, domain and range features&nbsp;<?php echo $references->cite("MunozPG09"); ?>; these rules may be considered incomplete, not capturing, for example, that every class is a sub-class of itself, that every property is a sub-property of itself, etc. A more comprehensive set of rules for the OWL features of Tables&nbsp;<?php echo ref("tab:ontEqIneq"). "–" .ref("tab:ontClass"); ?> have been defined as OWL 2 RL/RDF&nbsp;<?php echo $references->cite("key:owl2profiles"); ?>; these rules are likewise incomplete as such rules cannot fully capture negation (e.g., <span class="sc">Complement</span>), existentials (e.g., <span class="sc">Some Values</span>), universals (e.g., <span class="sc">All Values</span>), or counting (e.g., <span class="sc">Cardinality</span> and <span class="sc">Qualified Cardinality</span>). Other rule languages have, however, been proposed to support additional such features, including existentials (see, e.g., Datalog\(^\pm\)&nbsp;<?php echo $references->cite("BellomariniSG18"); ?>), disjunction (see, e.g., Disjunctive Datalog&nbsp;<?php echo $references->cite("RudolphKH08"); ?>), etc.</p>

		<table class="normalTable" id="tab-rulesRdfs">
			<caption>Example rules for sub-class, sub-property, domain, and range features <a class="git" title="Consult the code for this example on Github" href="https://github.com/Knowledge-Graphs-Book/examples/blob/main/Chapter_4_Deductive_Knowledge/4_2_1_Rules/table_4_4.rif"></a></caption>
			<thead>
				<tr>
					<th>Feature</th>
					<th>Body</th>
					<th>\(\Rightarrow\)</th>
					<th>Head</th>
				</tr>
			</thead>
			<tbody>
				<tr>
					<td>Sub-class (I)</td>
					<td><?php echo sedge("?x","type",NULL,"?c","gvar"); ?><?php echo esource(); ?><span class="edge">subc.&nbsp;of</span><?php echo etipr(); ?><span class="gvar">?d</span></td>
					<td>\(\Rightarrow\)</td>
					<td><?php echo sedge("?x","type",NULL,"?d","gvar"); ?></td>
				</tr>
				<tr>
					<td>Sub-class (II)</td>
					<td><?php echo sedge("?c","subc.&nbsp;of",NULL,"?d","gvar"); ?><?php echo esource(); ?><span class="edge">subc.&nbsp;of</span><?php echo etipr(); ?><span class="gvar">?e</span></td>
					<td>\(\Rightarrow\)</td>
					<td><?php echo sedge("?c","subc.&nbsp;of",NULL,"?e","gvar"); ?></td>
				</tr>
				<tr>
					<td>Sub-property (I)</td>
					<td><img class="inside" src="images/tab-rulesRdfs-subprop.svg" alt="sub-proprety (I) body" /></td>
					<td>\(\Rightarrow\)</td>
					<td><?php echo sedge("?x","?q",NULL,"?y","gvar"); ?></td>
				</tr>
				<tr>
					<td>Sub-property (II)</td>
					<td><?php echo sedge("?p","subp.&nbsp;of",NULL,"?q","gvar"); ?><?php echo esource(); ?><span class="edge">subp.&nbsp;of</span><?php echo etipr(); ?><span class="gvar">?r</span></td>
					<td>\(\Rightarrow\)</td>
					<td><?php echo sedge("?p","subp.&nbsp;of",NULL,"?r","gvar"); ?></td>
				</tr>
				<tr>
					<td>Domain</td>
					<td><img class="inside" src="images/tab-rulesRdfs-domain.svg" alt="domain body" /></td>
					<td>\(\Rightarrow\)</td>
					<td><?php echo sedge("?x","type",NULL,"?c","gvar"); ?></td>
				</tr>
				<tr>
					<td>Range</td>
					<td><img class="inside" src="images/tab-rulesRdfs-range.svg" alt="range body" /></td>
					<td>\(\Rightarrow\)</td>
					<td><?php echo sedge("?y","type",NULL,"?c","gvar"); ?></td>
				</tr>
			</tbody>
		</table>

		<p>Rules can be leveraged for reasoning in a number of ways. <em>Materialisation</em> refers to the idea of applying rules recursively to a graph, adding the conclusions generated back to the graph until a fixpoint is reached and nothing more can be added. The materialised graph can then be treated as any other graph. Although the efficiency and scalability of materialisation can be enhanced through optimisations like Rete networks&nbsp;<?php echo $references->cite("Forgy82"); ?>, or using distributed frameworks like MapReduce&nbsp;<?php echo $references->cite("UrbaniKMHB12"); ?>, depending on the rules and the data, the materialised graph may become unfeasibly large to manage. Another strategy is to use rules for <em>query rewriting</em>, which given a query, will automatically extend the query in order to find solutions entailed by a set of rules; for example, taking the schema graph in Figure&nbsp;<?php echo ref("fig:sg"); ?> and the rules in Table&nbsp;<?php echo ref("tab:rulesRdfs"); ?>, the (sub-)pattern <span class="gvar">?x</span><?php echo esource(); ?><span class="edge">type</span><?php echo etipr(); ?><span class="gnode">Event</span> in a given input query would be rewritten to the following disjunctive pattern evaluated on the original graph:</p>

		<p class="mathblock"><span class="gvar">?x</span><?php echo esource(); ?><span class="edge">type</span><?php echo etipr(); ?><span class="gnode">Event</span> \(\cup\) <span class="gvar">?x</span><?php echo esource(); ?><span class="edge">type</span><?php echo etipr(); ?><span class="gnode">Type</span> \(\cup\) <span class="gvar">?x</span><?php echo esource(); ?><span class="edge">type</span><?php echo etipr(); ?><span class="gnode">Periodic&nbsp;Market</span> \(\cup\) <?php echo sedge("?x","venue",NULL,"?y","gvar"); ?></p>

		<p>Figure&nbsp;<?php echo ref("fig:qrew"); ?> provides a more complete example of an ontology that is used to rewrite the query of Figure&nbsp;<?php echo ref("fig:bgpFS"); ?>; if evaluated over the graph of Figure&nbsp;<?php echo ref("fig:delg"); ?>, <span class="gnode">Ñam</span> will be returned as a solution. However, not all of the aforementioned features of OWL can be supported in this manner. The OWL 2 QL profile&nbsp;<?php echo $references->cite("key:owl2profiles"); ?> is a subset of OWL designed specifically for query rewriting of this form&nbsp;<?php echo $references->cite("ArtaleCKZ09"); ?>.</p>

		<figure id="fig-qrew">
			<dl>
				<dt>\(O:\)</dt>
				<dd>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<img class="inlined" src="images/fig-qrew1.svg" alt="ontology"/></dd>
				<dt>\(Q(O):\)</dt>
				<dd>&nbsp;&nbsp;&nbsp;&nbsp;\((\)<img class="inlined" src="images/fig-qrew2.svg" alt="type Festival"/> \(\cup\) <img class="inlined" src="images/fig-qrew3.svg" alt="type Food Festival"/> \(\cup\) <img class="inlined" src="images/fig-qrew4.svg" alt="type Drinks Festival"/>\()\)</dd>
				<dd>\(\Join (\)<img class="inlined" src="images/fig-qrew5.svg" alt="location Santiago"/> \(\cup\) <img class="inlined" src="images/fig-qrew6.svg" alt="venue city Santiago"/>\()\)</dd>
				<dd>\(\Join \) &nbsp;<img class="inlined" src="images/fig-qrew7.svg" alt="name"/></dd>
			</dl>
			<figcaption>Query rewriting example for the query \(Q\) of Figure&nbsp;<?php echo ref("fig:bgpFS"); ?> <a class="git" title="Consult the code for this example on Github" href="https://github.com/Knowledge-Graphs-Book/examples/blob/main/Chapter_4_Deductive_Knowledge/4_2_1_Rules/"></a></figcaption>
		</figure>

		<p>While rules can be used to (partially) capture ontological entailments, they can also be defined independently of an ontology language, capturing entailments for a given domain. In fact, some rules – such as the following – cannot be captured by the ontology features previously seen, as they do not support ways to infer relations from cyclical graph patterns (for computability reasons):</p>
		
		<p class="mathblock"><img class="inside" src="images/fig-inline-rule.svg" alt="dom flight rule premise" style="margin-right:2em;vertical-align:middle;position:relative;"/> \(\Rightarrow\) <?php echo sedge("?x","domestic&nbsp;flight",NULL,"?y","gvar"); ?> <a class="git" title="Consult the code for this example on Github" href="https://github.com/Knowledge-Graphs-Book/examples/blob/main/Chapter_4_Deductive_Knowledge/4_2_1_Rules/flight-rule.rif"></a></p>

		<p>Various languages allow for expressing rules over graphs – independently or alongside of an ontology language – including: Notation3 (N3)&nbsp;<?php echo $references->cite("n3"); ?>, Rule Interchange Format (RIF)&nbsp;<?php echo $references->cite("rif"); ?>, Semantic Web Rule Language (SWRL)&nbsp;<?php echo $references->cite("swrl"); ?>, and SPARQL Inferencing Notation (SPIN)&nbsp;<?php echo $references->cite("spin"); ?>, amongst others.</p>

		<div class="formal">
			<p>Given a graph pattern \(Q\) – be it a directed edge-labelled graph pattern per Definition&nbsp;<?php echo ref("def:delgp"); ?> or a property graph pattern per Definition&nbsp;<?php echo ref("def:pgp"); ?> – recall that \(\var(Q)\) denotes the variables appearing in \(Q\). We now define rules for graphs.</p>

			<dl class="definition" id="def-rule">
				<dt>Rule</dt>
				<dd>A <em>rule</em> is a pair \(R \coloneqq (B,H)\) such that \(B\) and \(H\) are graph patterns and \(\var(H) \subseteq B\). The graph pattern \(B\) is called the <em>body</em> of the rule while \(H\) is called the <em>head</em> of the rule. </dd>
			</dl>

			<p>This definition of a rule applies for directed edge-labelled graphs and property graphs by considering the corresponding type of graph pattern. The head is considered to be a conjunction of edges. Given a graph \(G\), a rule is <em>applied</em> by computing the mappings from the body to the graph and then using those mappings to substitute the variables in \(H\). The restriction \(\var(H) \subseteq B\) ensures that the results of this substitution is a graph, with no variables in \(H\) left unsubstituted.</p>

			<dl class="definition" id="def-rule-application">
				<dt>Rule application</dt>
				<dd>Given a rule \(R = (B,H)\) and a graph \(G\), we define the <em>application of \(R\) over \(G\)</em> as the graph \(R(G) \coloneqq \bigcup_{\mu \in B(G)} \mu(H)\).</dd>
			</dl>

			<p>Given a set of rules \(\mathcal{R} \coloneqq \{ R_1, \ldots, R_n \}\) and a knowledge graph \(G\), towards defining the set of inferences given by the rules over the graph, we denote by \(\mathcal{R}(G) \coloneqq \bigcup_{R \in \mathcal{R}} R(G)\) the union of the application of all rules of \(\mathcal{R}\) over \(G\), and we denote by \(\mathcal{R}^+(G) \coloneqq \mathcal{R}(G) \cup G\) the extension of \(G\) with respect to the application of \(\mathcal{R}\). Finally, we denote by \(\mathcal{R}^k(G)\) (for \(k \in \mathbb{N^+}\)) the recursive application of \(\mathcal{R}^+(G)\), where \(\mathcal{R}^1(G) \coloneqq \mathcal{R}^+(G)\), and \(\mathcal{R}^{i+1}(G) \coloneqq \mathcal{R}^+(\mathcal{R}^{i}(G))\). We are now ready to define the <em>least model</em>, which captures the inferences possible for \(\mathcal{R}\) over \(G\).</p>

			<dl class="definition" id="def-least-model">
				<dt>Least model</dt>
				<dd>The <em>least model of \(\mathcal{R}\)</em> over \(G\)} is defined as \(\mathcal{R}^*(G) \coloneqq \bigcup_{k\in \mathbb{N}}(R^k(G))\).</dd>
			</dl>

			<p>At some point \(R^{k'}(G) = R^{k'+1}(G)\): the rule applications reach a fixpoint and we have the least model. Once the least model \(\mathcal{R}^*(G)\) is computed, the entailed data can be treated as any other data.</p>
			<p>Rules can support graph entailments of the form \(G_1 \models_\Phi G_2\). We say that a set of rules \(\mathcal{R}\) is <em>correct</em> for \(\Phi\) if, for any graph \(G\), \(G \models_\Phi \mathcal{R}^*(G)\). We say that \(\mathcal{R}\) is <em>complete</em> for \(\Phi\) if, for any graph \(G\), there does not exist a graph \(G' \not\subseteq \mathcal{R}^*(G)\) such that \(G \models_\Phi G'\). Table&nbsp;<?php echo ref("tab:rulesRdfs"); ?> exemplifies a correct but incomplete set of rules for the semantic conditions of the RDFS standard&nbsp;<?php echo $references->cite("RDFS"); ?>.</p>
			<p>Alternatively, rather than supporting ontology-based graph entailments, rules can be directly specified in a rule language such as Notation3 (N3)&nbsp;<?php echo $references->cite("n3"); ?>, Rule Interchange Format (RIF)&nbsp;<?php echo $references->cite("rif"); ?>, Semantic Web Rule Language (SWRL)&nbsp;<?php echo $references->cite("swrl"); ?>, or SPARQL Inferencing Notation (SPIN)&nbsp;<?php echo $references->cite("spin"); ?>. Languages such as SPIN represent rules as graphs, allowing the rules of a knowledge graph to be embedded in the data graph. Taking advantage of this fact, we can then consider a form of graph entailment \(G_1 \cup \gamma(\mathcal{R}) \models_\Phi G_2\), where by \(\gamma(\mathcal{R})\) we denote the graph representation of rules \(\mathcal{R}\). If the set of rules \(\mathcal{R}\) is correct and complete for \(\Phi\), we may simply write \(G_1 \cup \gamma(\mathcal{R}) \models G_2\), indicating that \(\Phi\) captures the same semantics for \(\gamma(\mathcal{R})\) as applying the rules in \(\mathcal{R}\). Rules thus offer another form of graph entailment.</p>
		</div>

		<h4 id="sssec-dls" class="subsection">Description Logics</h4>
		<p>Description Logics (DLs) were initially introduced as a way to formalise the meaning of <em>frames</em>&nbsp;<?php $references->cite("minsky"); ?> and <em>semantic networks</em>&nbsp;<?php $references->cite("quillian"); ?>. Since semantic networks are an early version of knowledge graphs, and DLs have heavily influenced the Web Ontology Language, DLs thus hold an important place in the logical formalisation of knowledge graphs. DLs form a family of logics rather than a particular logic. Initially, DLs were restricted fragments of FOL that permit decidable reasoning tasks, such as entailment checking&nbsp;<?php echo $references->cite("BaaderHLS17"); ?>. Different DLs strike different balances between expressive power and computational complexity of reasoning. DLs were later extended with features beyond FOL that are useful in the context of modelling graph data, such as transitive closure, datatypes, etc.</p>
		<p>DLs are based on three types of elements: <em>individuals</em>, such as <code>Santiago</code>; <em>classes</em> (aka <em>concepts</em>) such as <code>City</code>; and <em>properties</em> (aka <em>roles</em>) such as <code>flight</code>. DLs then allow for making claims, known as <em>axioms</em>, about these elements. <em>Assertional axioms</em> can be either unary class relations on individuals, such as <code>City(Santiago)</code>, or binary property relations on individuals, such as <code>flight(Santiago,Arica)</code>. Such axioms form the <em>Assertional Box</em> (<em>A-Box</em>). DLs further introduce logical symbols to allow for defining <em>class axioms</em> (forming the <em>Terminology Box</em>, or <em>T-Box</em> for short), and <em>property axioms</em> (forming the <em>Role Box</em>, <em>R-Box</em>); for example, the class axiom <span class="nobreak"><code>City</code>&nbsp;\(\sqsubseteq\)&nbsp;<code>Place</code></span> states that the former class is a sub-class of the latter one, while the property axiom <span class="nobreak"><code>flight</code>&nbsp;\(\sqsubseteq\)&nbsp;<code>connectsTo</code></span> states that the former property is a sub-property of the latter one. DLs may then introduce a rich set of logical symbols, not only for defining class and property axioms, but also defining new classes based on existing terms; as an example of the latter, we can define a class <span class="nobreak">\(\exists\)<code>nearby</code>.<code>Airport</code></span> as the class of individuals that have some airport nearby. Noting that the symbol \(\top\) is used in DLs to denote the class of all individuals, we can then add a class axiom <span class="nobreak">\(\exists\)<code>flight</code>.\(\top \sqsubseteq \exists\)<code>nearby</code>.<code>Airport</code></span> to state that individuals with an outgoing flight must have some airport nearby. Noting that the symbol \(\sqcup\) can be used in DL to define that a class is the union of other classes, we can further define, for example, that <code>Airport</code>&nbsp;\(\sqsubseteq\)&nbsp;<code>DomesticAirport</code> \(\sqcup\) <code>InternationalAirport</code>, i.e., that an airport is either a domestic airport or an international airport (or both).</p>
		<p>The similarities between DL features and the OWL features seen previously are not coincidental: the OWL standard was heavily influenced by DLs, where, for example, the OWL 2 DL language is a fragment of OWL restricted so that entailment becomes decidable, where the restrictions are inspired by those defined for DLs. To exemplify a restriction, <span class="nobreak"><code>DomesticAirport</code>&nbsp;\(\sqsubseteq ~=1\)&nbsp;<code>destination</code> \(\circ\) <code>country</code>.\(\top\)</span> defines in DL syntax that domestic airports have flights destined to precisely one country (where <span class="nobreak"><code>p</code>&nbsp;\(\circ\)&nbsp;<code>q</code></span> denotes a chain of properties). However, counting chains (in this case with \(=1~\texttt{destination} \circ \texttt{country}\)) is often disallowed in DLs to ensure decidability.</p>
		<p>Expressive DLs support complex entailments involving existentials, universals, counting, etc. A common strategy for deciding such entailments is to reduce entailment to <em>satisfiability</em>, which decides if an ontology is consistent or not&nbsp;<?php echo $references->cite("HorrocksP04"); ?>.<?php echo footnote("\\(G\\) entails \\(G'\\) if and only if \\(G \\cup \\text{not}(G')\\) is not satisfiable, i.e., it has no model."); ?> Thereafter methods such as <em>tableau</em> can be used to check satisfiability, cautiously constructing models by completing them along similar lines to the materialisation strategy previously described, but additionally branching models in the case of disjunction, introducing new elements to represent existentials, etc. If any model is successfully “completed”, the process concludes that the original definitions are satisfiable (see, e.g.,&nbsp;<?php echo $references->cite("MotikSH09"); ?>). Due to their prohibitive computational complexity&nbsp;<?php echo $references->cite("key:owl2profiles"); ?> – where for example, disjunction may lead to an exponential number of branching possibilities – such reasoning strategies are not typically applied in the case of large-scale data, though they may be useful when modelling complex domains for knowledge graphs.</p>

		<div class="formal">
			<p>A DL knowledge base consists of an A-Box, a T-Box, and an R-Box.</p>

			<dl class="definition" id="def-dl-knowledg-base">
				<dt>DL knowledge base</dt>
				<dd><em>DL knowledge base</em> \(\mathsf{K}\) is defined as a tuple \((\mathsf{A},\mathsf{T},\mathsf{R})\), where \(\mathsf{A}\) is the <em>A-Box</em>: a set of assertional axioms; \(\mathsf{T}\) is the <em>T-Box</em>: a set of class (aka concept/terminological) axioms; and \(\mathsf{R}\) is the <em>R-Box</em>: a set of relation (aka property/role) axioms.</dd>
			</dl>

			<p>Table&nbsp;<?php echo ref("tab:dlsem"); ?> provides definitions for all of the constructs typically found in Description Logics. The syntax column denotes how the construct is expressed in DL. The semantics column defines the meaning of axioms using <em>interpretations</em>, which are defined in a slightly different way to those seen previously for graphs.</p>

			<dl class="definition" id="def-dl-interpretation">
				<dt>DL interpretation</dt>
				<dd>A <em>DL interpretation</em> \(I\) is defined as a pair \((\inpdom,\inp{\cdot})\), where \(\inpdom\) is the <em>interpretation domain</em>, and \(\inp{\cdot}\) is the <em>interpretation function</em>. The interpretation domain is a set of individuals. The interpretation function accepts a definition of either an individual \(a\), a class \(C\), or a relation \(R\), mapping them, respectively, to an element of the domain (\(\inp{a} \in \inpdom\)), a subset of the domain (\(\inp{C} \subseteq \inpdom\)), or a set of pairs from the domain (\(\inp{R} \subseteq \inpdom \times \inpdom\)).</dd>
			</dl>

			<p>An interpretation \(I\) <em>satisfies</em> a knowledge-base \(\mathsf{K}\) if and only if, for all of the syntactic axioms in <span style="white-space:nowrap;">\(\mathsf{K}\),</span> the corresponding semantic conditions in Table&nbsp;<?php echo ref("tab:dlsem"); ?> hold for \(I\). In this case, we call \(I\) a <em>model</em> of \(\mathsf{K}\).</p>
			
			<div class="example" id="ex-entail">
				<p>For \(\mathsf{K} \coloneqq (\mathsf{A},\mathsf{T},\mathsf{R})\), let:</p>
				<ul>
					<li>\(\mathsf{A} \coloneqq \{ \)<code>City(Arica)</code>, <code>City(Santiago)</code>, <code>flight(Arica,Santiago)</code>\(\}\);</li>
					<li>\(\mathsf{T} \coloneqq \{\)<code>City</code> \(\sqsubseteq\) <code>Place</code>, \(\exists\)<code>flight</code>\(.\top \sqsubseteq \exists\)<code>nearby</code>.<code>Airport</code>\(\} \);</li>
					<li>\(\mathsf{R} \coloneqq \{\)<code>flight</code> \(\sqsubseteq\) <code>connectsTo</code>\(\} \).</li>
				</ul>
				<p>For \(I = (\inpdom,\inp{\cdot})\), let:</p>
				<ul>
					<li>\(\inpdom \coloneqq \{ ⚓,\,🏔,\,✈ \}\);</li>
					<li><code>Arica</code><sup>\(I\)</sup> \(\coloneqq\,⚓\), <code>Santiago</code><sup>\(I\)</sup> \(\coloneqq\,🏔\), <code>AricaAirport</code><sup>\(I\)</sup> \(\coloneqq\,✈\);</li>
					<li><code>City</code><sup>\(I\)</sup> \(\coloneqq \{ ⚓,\,🏔 \}\), <code>Airport</code><sup>\(I\)</sup> \(\coloneqq \{ ✈ \}\);</li>
					<li><code>flight</code><sup>\(I\)</sup> \(\coloneqq \{ (⚓,\,🏔) \}\), <code>connectsTo</code><sup>\(I\)</sup> \(\coloneqq \{ (⚓,\,🏔) \}\), <code>sells</code><sup>\(I\)</sup> \(\coloneqq \{ (✈,\,☕) \}\).</li>
				</ul>
				<p>The interpretation \(I\) is not a model of \(\mathsf{K}\) since it does not have that \(⚓\) is <code>nearby</code> some <code>Airport</code>, nor that \(⚓\) and \(🏔\) are in the class <code>Place</code>. However, if we <em>extend</em> the interpretation \(I\) with the following:</p>
				<ul>
					<li><code>Place</code><sup>\(I\)</sup> \(\coloneqq \{ ⚓,\,🏔 \}\);</li>
					<li><code>nearby</code> \(\coloneqq \{ (⚓,\,✈) \}\).</li>
				</ul>
				<p>Now \(I\) is a model of \(\mathsf{K}\). Note that although \(\mathsf{K}\) does not imply that <code>sells(AricaAirport,coffee)</code> while \(I\) indicates that \(✈\) does indeed sell \(☕\), \(I\) is still a model of \(\mathsf{K}\) since \(\mathsf{K}\) is not assumed to be a complete description, per the OWA.</p>
			</div>
			
			<p>Finally, the notion of a model gives rise to the notion of entailment, which tells us which knowledge bases hold as a logical consequence of which others.</p>

			<dl class="definition" id="def-entailment">
				<dt>Entailment</dt>
				<dd>Given two DL knowledge bases \(\mathsf{K}_1\) and \(\mathsf{K}_2\), we define that \(\mathsf{K}_1\) entails \(\mathsf{K}_2\), denoted \(\mathsf{K}_1 \models \mathsf{K}_2\), if and only if any model of \(\mathsf{K}_1\) is a model of \(\mathsf{K}_2\).</dd>
			</dl>

			<div class="example">
				<p>Let \(\mathsf{K}_1\) denote the knowledge base \(\mathsf{K}\) from the Example&nbsp;<?php echo ref("ex:entail"); ?>, and define a second knowledge base with one assertion: \(\mathsf{K}_2 \coloneqq ( \{ \)<code>connectsTo</code>\((\)<code>Arica</code>, <code>Santiago</code>\() \}, \{\}, \{\} )\) with one assertion. Though \(\mathsf{K}_1\) does not assert this axiom, it does entail \(\mathsf{K}_2\): to be a model of \(\mathsf{K}_2\), an interpretation must have that \((\)<code>Arica</code><sup>\(I\)</sup>, <code>Santiago</code>\() \in\) <code>connectsTo</code><sup>\(I\)</sup>, but this must also be the case for any interpretation that satisfies \(\mathsf{K}_1\) since it must have that \((\)<code>Arica</code><sup>\(I\)</sup>, <code>Santiago</code><sup>\(I\)</sup>\() \in \)<code>flight</code> and <code>flight</code> \(\subseteq\) <code>connectsTo</code><sup>\(I\)</sup>. Hence any model of \(\mathsf{K}_1\) must also be a model of \(\mathsf{K}_2\), and \(\mathsf{K}_1 \models \mathsf{K}_2\) holds.</p>
			</div>

			<p>Unfortunately, the problem of deciding entailment for knowledge bases expressed in the DL composed of the unrestricted use of all of the axioms of Table&nbsp;<?php echo ref("tab:dlsem"); ?> is undecidable since we could reduce instances of the Halting Problem to such entailment. Hence DLs in practice restrict use of the features listed in Table&nbsp;<?php echo ref("tab:dlsem"); ?>. Different DLs apply different restrictions, implying different trade-offs for expressivity and the complexity of entailment. Most DLs are founded on one of the following base DLs (we use indentation to denote derivation):</p>
			<ul>
				<li>[\(\mathcal{ALC}\)] (\(\mathcal{A}\)ttributive \(\mathcal{L}\)anguage with \(\mathcal{C}\)omplement}&nbsp;<?php echo $references->cite("Schmidt-SchaussS91"); ?>), supports atomic classes, the top and bottom classes, class intersection, class union, class negation, universal restrictions and existential restrictions. Relation and class assertions are also supported.<ul>
					<li>[\(\mathcal{S}\)] extends \(\mathcal{ALC}\) with transitive closure.</li>
				</ul></li>
			</ul>
			<p>These base languages can be extended as follows:</p>
			<ul>
				<li>[\(\mathcal{H}\)] adds relation inclusion.<ul>
					<li>[\(\mathcal{R}\)] adds (limited) complex relation inclusion, relation reflexivity, relation irreflexivity, relation disjointness and the universal relation.</li>
				</ul></li>
				<li>[\(\mathcal{O}\)] adds (limited) nomimals.</li>
				<li>[\(\mathcal{I}\)] adds inverse relations.</li>
				<li>[\(\mathcal{F}\)] adds (limited) functional properties.<ul>
					<li>[\(\mathcal{N}\)] adds (limited) number restrictions (covering \(\mathcal{F}\) with \(\top\)).<ul>
						<li>[\(\mathcal{Q}\)] adds (limited) qualified number restrictions (covering \(\mathcal{N}\) with \(\top\)).</li>
					</ul></li>
				</ul></li>
			</ul>
			<p>We use “(limited)” to indicate that such features are often only allowed under certain restrictions to ensure decidability; for example, complex relations (chains) typically cannot be combined with cardinality restrictions. DLs are then typically named per the following scheme, where \([a|b]\) denotes an alternative between \(a\) and \(b\) and \([c][d]\) denotes a concatenation \(cd\):</p>
			<p>\[ [\mathcal{ALC}|\mathcal{S}][\mathcal{H}|\mathcal{R}][\mathcal{O}][\mathcal{I}][\mathcal{F}|\mathcal{N}|\mathcal{Q}] \]</p>
			<p>Examples include \(\mathcal{ALCO}\), \(\mathcal{ALCHI}\), \(\mathcal{SHIF}\), \(\mathcal{SROIQ}\), etc. These languages often apply additional restrictions on class and property axioms to ensure decidability, which we do not discuss here. For further details on DLs, we refer to the recent book by <?php echo $references->citet("BaaderHLS17"); ?>.</p>
			<p>As mentioned in the body of the survey, DLs have been very influential in the definition of OWL, where the OWL 2 DL fragment (roughly) corresponds to the DL \(\mathcal{SROIQ}\). For example, the axiom <?php echo gedge("venue","domain","Event"); ?> in OWL can be translated to \(\exists\)<code>venue</code>\(.\top \sqsubseteq\) <code>Event</code>, meaning that the class of individuals with some value for <code>venue</code> (in any class) is a sub-class of the class <code>Event</code>. We leave other translations from the OWL axioms of Tables&nbsp;<?php echo ref("tab:ontEqIneq"); ?>–<?php echo ref("tab:ontClass"); ?> to DL as an exercise.<?php echo footnote("Though not previously mentioned, OWL additionally defines the classes <code>Thing</code> and <code>Nothing</code> that correspond to \\(\\top\\) and \\(\\bot\\), respectively."); ?> Note, however, that axioms like <?php echo gedge("sub-taxon of","subp. of","subc. of"); ?> – which given a graph such as <?php echo gedge("Fred","type","Homo sapiens") . esource(); ?><span class="edge">sub-taxon of</span><?php echo etipr(); ?><span class="gnode">Hominini</span> entails the edge <?php echo gedge("Fred","type","Hominini"); ?> – cannot be expressed in DL: “<code>subTaxonOf</code> \(\sqsubseteq\ \sqsubseteq\)” is not syntactically valid. Hence only a subset of graphs can be translated into well-formed DL ontologies; we refer to the OWL standard for details&nbsp;<?php echo $references->cite("OWL2"); ?>.</p>
		</div>

		<div class="formal-table">
			<table id="tab-dlsem">
				<caption>Description Logic semantics (such that \(x, y, z, \inp{a}, \inp{a_1}, \ldots \inp{a_n}, \inp{b}\) are in \(\inpdom\))</caption>
				<thead>
					<tr>
						<th>Name</th>
						<th>Syntax</th>
						<th>Semantics (\(\inp{\cdot}\))</th>
					</tr>
				</thead>
				<tbody>
					<tr>
						<td class="subtabhead" colspan="3"><span class="sc">Class Definitions</span></td>
					</tr>
					<tr>
						<td>Atomic Class</td>
						<td>\(A\)</td>
						<td>\(\inp{A}\) (a subset of \(\inpdom)\)</td>
					</tr>
					<tr>
						<td>Top Class</td>
						<td>\(\top\)</td>
						<td>\(\inpdom\)</td>
					</tr>
					<tr>
						<td>Bottom Class</td>
						<td>\(\bot\)</td>
						<td>\(\emptyset\)</td>
					</tr>
					<tr>
						<td>Class Negation</td>
						<td>\(\neg C\)</td>
						<td>\(\inpdom \setminus \inp{C}\)</td>
					</tr>
					<tr>
						<td>Class Intersection</td>
						<td>\(C \sqcap D\)</td>
						<td>\(\inp{C} \cap \inp{D}\)</td>
					</tr>
					<tr>
						<td>Class Union</td>
						<td>\(C \sqcup D\)</td>
						<td>\(\inp{C} \cup \inp{D}\)</td>
					</tr>
					<tr>
						<td>Nominal</td>
						<td>\(\{ a_1, ..., a_n \}\)</td>
						<td>\(\{ \inp{a_1}, ..., \inp{a_n} \}\)</td>
					</tr>
					<tr>
						<td>Existential Restriction</td>
						<td>\(\exists R.C\)</td>
						<td>\(\{ x \mid \exists y : (x,y) \in \inp{R}\text{ and }y \in \inp{C} \}\)</td>
					</tr>
					<tr>
						<td>Universal Restriction</td>
						<td>\(\forall R.C\)</td>
						<td>\(\{ x \mid \forall y : (x,y) \in \inp{R}\text{ implies }y \in \inp{C} \}\)</td>
					</tr>
					<tr>
						<td>Self Restriction</td>
						<td>\(\exists R.\textsf{Self}\)</td>
						<td>\(\{ x \mid (x,x) \in \inp{R} \}\)</td>
					</tr>
					<tr>
						<td>Number Restriction</td>
						<td>\(\star\,n\,R\) (where \(\star \in \{\geq, \leq, = \}\))</td>
						<td>\(\{ x \mid \#\{ y : (x,y) \in \inp{R} \} \star n \}\)</td>
					</tr>
					<tr>
						<td>Qualified&#x202F;Number&#x202F;Restriction</td>
						<td>\(\star\,n\,R.C\)&#x202F;(where&#x202F;\(\star \in \{\geq, \leq, = \}\))</td>
						<td>\(\{ x \mid \#\{ y : (x,y) \in \inp{R}\text{ and }y \in \inp{C} \} \star n \}\)</td>
					</tr>
				</tbody>
				<tbody>
					<tr>
						<td class="subtabhead" colspan="3"><span class="sc">Class Axioms</span> (T-Box)</td>
					</tr>
					<tr>
						<td>Class Inclusion</td>
						<td>\(C \sqsubseteq D\)</td>
						<td>\(\inp{C} \subseteq \inp{D}\)</td>
					</tr>
				</tbody>
				<tbody>
					<tr>
						<td class="subtabhead" colspan="3"><span class="sc">Relation Definitions</span></td>
					</tr>
					<tr>
						<td>Relation</td>
						<td>\(R\)</td>
						<td>\(\inp{R}\) (a subset of \(\inpdom \times \inpdom\))</td>
					</tr>
					<tr>
						<td>Inverse Relation</td>
						<td>\(R^{-}\)</td>
						<td>\(\{ (y,x) \mid (x,y) \in \inp{R} \}\)</td>
					</tr>
					<tr>
						<td>Universal Relation</td>
						<td>\(\textsf{U}\)</td>
						<td>\(\inpdom \times \inpdom\)</td>
					</tr>
				</tbody>
				<tbody>
					<tr>
						<td class="subtabhead" colspan="3"><span class="sc">Relation Axioms</span> (R-Box)</td>
					</tr>
					<tr>
						<td>Relation Inclusion</td>
						<td>\(R \sqsubseteq S\)</td>
						<td>\(\inp{R} \subseteq \inp{S}\)</td>
					</tr>
					<tr>
						<td>Complex Relation Inclusion</td>
						<td>\(R_1 \circ ... \circ R_n \sqsubseteq S\)</td>
						<td>\(\inp{R_1} \circ ... \circ \inp{R_n} \subseteq \inp{S}\)</td>
					</tr>
					<tr>
						<td>Transitive Relations</td>
						<td>\(\textsf{Trans}(R)\)</td>
						<td>\(\inp{R} \circ \inp{R} \subseteq \inp{R}\)</td>
					</tr>
					<tr>
						<td>Functional Relations</td>
						<td>\(\textsf{Func}(R)\)</td>
						<td>\(\{ (x,y), (x,z) \} \subseteq \inp{R} \)implies \(y = z\)</td>
					</tr>
					<tr>
						<td>Reflexive Relations</td>
						<td>\(\textsf{Ref}(R)\)</td>
						<td>for all \(x : (x,x) \in \inp{R}\)</td>
					</tr>
					<tr>
						<td>Irreflexive Relations</td>
						<td>\(\textsf{Irref}(R)\)</td>
						<td>for all \(x : (x,x) \not\in \inp{R}\)</td>
					</tr>
					<tr>
						<td>Symmetric Relations</td>
						<td>\(\textsf{Sym}(R)\)</td>
						<td>\(\inp{R} = \inp{(R^{-})}\)</td>
					</tr>
					<tr>
						<td>Asymmetric Relations</td>
						<td>\(\textsf{Asym}(R)\)</td>
						<td>\(\inp{R} \cap \inp{(R^{-})} = \emptyset\)</td>
					</tr>
					<tr>
						<td>Disjoint Relations</td>
						<td>\(\textsf{Disj}(R,S)\)</td>
						<td>\(\inp{R} \cap \inp{S} = \emptyset\)</td>
					</tr>
				</tbody>
				<tbody>
					<tr>
						<td class="subtabhead" colspan="3"><span class="sc">Assertional Definitions</span></td>
					</tr>
					<tr>
						<td>Individual</td>
						<td>\(a\)</td>
						<td>\(\inp{a}\)</td>
					</tr>
				</tbody>
				<tbody>
					<tr>
						<td class="subtabhead" colspan="3"><span class="sc">Assertional Axioms</span> (A-Box)</td>
					</tr>
					<tr>
						<td>Relation Assertion</td>
						<td>\(R(a,b)\)</td>
						<td>\((\inp{a},\inp{b}) \in \inp{R}\)</td>
					</tr>
					<tr>
						<td>Negative Relation Assertion</td>
						<td>\(\neg R(a,b)\)</td>
						<td>\((\inp{a},\inp{b}) \not\in \inp{R}\)</td>
					</tr>
					<tr>
						<td>Class Assertion</td>
						<td>\(C(a)\)</td>
						<td>\(\inp{a} \in \inp{C}\)</td>
					</tr>
					<tr>
						<td>Equality</td>
						<td>\( a = b \)</td>
						<td>\(\inp{a} = \inp{b}\)</td>
					</tr>
					<tr>
						<td>Inequality</td>
						<td>\( a \neq b \)</td>
						<td>\(\inp{a} \neq \inp{b}\)</td>
					</tr>
				</tbody>
			</table>
		</div>

		</section>
	</section>
