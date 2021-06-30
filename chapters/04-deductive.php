	<section id="chap-deductive" class="chapter">
		<h2>Deductive Knowledge</h2>
		<p>As humans, we can <em>deduce</em> more from the data graph of Figure&nbsp;<? echo ref("fig:delg"); ?> than what the edges explicitly indicate. We may deduce, for example, that the Ñam festival (<span class="gnode">EID15</span>) will be located in Santiago, even though the graph does not contain an edge <? echo gedge("EID15","location","Santiago"); ?>. We may further deduce that the cities connected by flights must have some airport nearby, even though the graph does not contain nodes referring to these airports. In these cases, given the data as premises, and some general rules about the world that we may know <em>a priori</em>, we can use a deductive process to derive new data, allowing us to know more than what is explicitly given by the data. These types of general premises and rules, when shared by many people, form part of “<em>commonsense knowledge</em>”&nbsp;<? echo $references->cite("Commonsense"); ?>; conversely, when rather shared by a few experts in an area, they form part of “<em>domain knowledge</em>”, where, for example, an expert in biology may know that <em>hemocyanin</em> is a protein containing copper that carries oxygen in the blood of some species of <em>Mollusca</em> and <em>Arthropoda</em>.</p>
		<p>Machines, in contrast, do not have <em>a priori</em> access to such deductive faculties; rather they need to be given formal instructions, in terms of premises and <em>entailment regimes</em>, in order to make similar deductions to what a human can make. These entailment regimes formalise the conclusions that logically follow as a consequence of a given set of premises. Once instructed in this manner, machines can (often) apply deductions with a precision, efficiency, and scale beyond human performance. These deductions may serve a range of applications, such as improving query answering, (deductive) classification, finding inconsistencies, etc. As a concrete example involving query answering, assume we are interested in knowing <em>the festivals located in Santiago</em>; we may straightforwardly express such a query as per the graph pattern shown in Figure&nbsp;<? echo ref("fig:bgpFS"); ?>. This query returns no results for the graph in Figure&nbsp;<? echo ref("fig:delg"); ?>: there is no node named <span class="gnode">Festival</span>, and nothing has (directly) the <span class="gelab">location</span> <span class="gnode">Santiago</span>. However, an answer (<span class="gnode">Ñam</span>) could be automatically entailed were we to state that \(x\) being a Food Festival <em>entails</em> that \(x\) is a Festival, or that \(x\) having venue \(y\) in city \(z\) <em>entails</em> that \(x\) has location \(z\). How, then, should such entailments be captured? In Section&nbsp;<? echo ref("sec:semSchema"); ?> we already discussed how the former entailment can be captured with sub-class relations in a semantic schema; the second entailment, however, requires a more expressive entailment regime than seen thus far.</p>

		<figure id="fig-bgpFS">
			<img src="images/fig-bgpFS.svg" alt="Graph pattern querying for names of festivals in Santiago"/>
			<figcaption>Graph pattern querying for names of festivals in Santiago</figcaption>
		</figure>

		<p>In this section, we discuss ways in which more complex entailments can be expressed and automated. Though we could leverage a number of logical frameworks for these purposes – such as First-Order Logic, Datalog, Prolog, Answer Set Programming, etc. – we focus on <em>ontologies</em>, which constitute a formal representation of knowledge that, importantly for us, can be represented as a graph. We then discuss how these ontologies can be formally defined, how they relate to existing logical frameworks, and how reasoning can be conducted with respect to such ontologies.</p>

		<section id="ssec-ontologies" class="section">
		<h3>Ontologies</h3>
		<p>To enable entailment, we must be precise about what the terms we use mean. Returning to Figure&nbsp;<? echo ref("fig:delg"); ?>, for example, and examining the node <span class="gnode">EID16</span> more closely, we may begin to question how it is modelled, particularly in comparison with <span class="gnode">EID15</span>. Both nodes – according to the class hierarchy of Figure&nbsp;<? echo ref("fig:classhier"); ?> – are considered to be events. But what if, for example, we wish to define two pairs of start and end dates for <span class="gnode">EID16</span> corresponding to the different venues? Should we rather consider what takes place in each venue as a different event? What then if an event has various start and end dates in a single venue: would these also be considered as one (recurring) event, or many events? These questions are facets of a more general question: <em>what precisely do we mean by an “event”</em>? Does it happen in one contiguous time interval or can it happen many times? Does it happen in one place or can it happen in multiple? There are no “correct” answers to such questions – we may understand the term “event” in a variety of ways, and thus the answers are a matter of <em>convention</em>.</p>
		<p>In the context of computing, an <em>ontology</em><? echo footnote("The term stems from the philosophical study of <em>ontology</em>, concerned with the different kinds of entities that exist, the nature of their existence, what kinds of properties they have, and how they may be identified and categorised."); ?> is then a concrete, formal representation of what terms mean within the scope in which they are used (e.g., a given domain). For example, one event ontology may formally define that if an entity is an “event”, then it has precisely one venue and precisely one time instant in which it begins. Conversely, a different event ontology may define that an “event” can have multiple venues and multiple start times, etc. Each such ontology formally captures a particular perspective – a particular <em>convention</em>. Under the first ontology, for example, we could not call the Olympics an “event”, while under the second ontology we could. Likewise ontologies can guide how graph data are modelled. Under the first ontology we may split <span class="gnode">EID16</span> into two events. Under the second, we may elect to keep <span class="gnode">EID16</span> as one event with two venues. Ultimately, given that ontologies are formal representations, they can be used to automate entailment.</p>
		<p>Like all conventions, the usefulness of an ontology depends on the level of agreement on what that ontology defines, how detailed it is, and how broadly and consistently it is adopted. Adoption of an ontology by the parties involved in one knowledge graph may lead to a consistent use of terms and consistent modelling in that knowledge graph. Agreement over multiple knowledge graphs will, in turn, enhance the interoperability of those knowledge graphs.</p>
		<p>Amongst the most popular ontology languages used in practice are the <em>Web Ontology Language</em> (<em>OWL</em>)&nbsp;<? echo $references->cite("OWL2"); ?><? echo footnote("We could include RDF Schema (RDFS) in this list, but it is largely subsumed by OWL, which builds upon its core."); ?>, recommended by the W3C and compatible with RDF graphs; and the <em>Open Biomedical Ontologies Format</em> (<em>OBOF</em>)&nbsp;<? echo $references->cite("obof"); ?>, used mostly in the biomedical domain. Since OWL is the more widely adopted, we focus on its features, though many similar features are found in both&nbsp;<? echo $references->cite("obof"); ?>. Before introducing such features, however, we must discuss how graphs are to be <em>interpreted</em>.</p>

		<h4 id="sssec-interpretations" class="subsection">Interpretations</h4>
		<p>We as humans may <em>interpret</em> the node <span class="gnode">Santiago</span> in the data graph of Figure&nbsp;<? echo ref("fig:delg"); ?> as referring to the real-world city that is the capital of Chile. We may further <em>interpret</em> an edge <? echo gedge("Arica","flight","Santiago"); ?> as stating that there are flights from the city of Arica to this city. We thus interpret the data graph as another graph – what we here call the <em>domain graph</em> – composed of real-world entities connected by real-world relations. The process of interpretation, here, involves <em>mapping</em> the nodes and edges in the data graph to nodes and edges of the domain graph.</p>
		<p>Along these lines, we can abstractly define an <em>interpretation</em> of a data graph as being composed of two elements: a domain graph, and a mapping from the <em>terms</em> (nodes and edge-labels) of the data graph to those of the domain graph. The domain graph follows the same model as the data graph; for example, if the data graph is a directed edge-labelled graph, then so too will be the domain graph. For simplicity, we will speak of directed edge-labelled graphs and refer to the nodes of the domain graph as <em>entities</em>, and the edges of the domain graph as <em>relations</em>. Given a data graph and an interpretation, while we denote nodes in the data graph by <span class="gnode">Santiago</span>, we will denote the entity it refers to in the domain graph by <span class="ginode">Santiago</span> (per the mapping of the given interpretation). Likewise, while we denote an edge by <? echo gedge("Arica","flight","Santiago"); ?>, we will denote the relation by <? echo giedge("Arica","flight","Santiago"); ?> (again, per the mapping of the given interpretation). In this abstract notion of an interpretation, we do not require that <span class="ginode">Santiago</span> nor <span class="ginode">Arica</span> be the real-world cities, nor even that the domain graph contain real-world entities and relations: an interpretation can have any domain graph and mapping.</p>
		<p>Why is such an abstract notion of interpretation useful? The distinction between nodes/edges and entities/relations becomes important when we define the meaning of ontology features and entailment. To illustrate this distinction, if we ask whether there is an edge labelled <span class="gelab">flight</span> between <span class="gnode">Arica</span> and <span class="gnode">Viña&nbsp;del&nbsp;Mar</span> for the data graph in Figure&nbsp;<? echo ref("fig:delg"); ?>, the answer is <em>no</em>. However, if we ask if the entities <span class="ginode">Arica</span> and <span class="ginode">Viña&nbsp;del&nbsp;Mar</span> are connected by the relation <span class="gielab">flight</span>, then the answer depends on what assumptions we make when interpreting the graph. Under the Closed World Assumption (CWA), if we do not have additional knowledge, then the answer is a definite <em>no</em> – since what is not known is assumed to be false. Conversely, under the Open World Assumption (OWA), we cannot be certain that this relation does not exist as this could be part of some knowledge not (yet) described by the graph. Likewise under the Unique Name Assumption (UNA), the data graph describes <em>at least two</em> flights to <span class="ginode">Santiago</span> (since <span class="ginode">Viña&nbsp;del&nbsp;Mar</span> and <span class="ginode">Arica</span> are assumed to be different entities and therefore, <? echo giedge("Arica","flight","Santiago"); ?> and <? echo giedge("Viña&nbsp;del&nbsp;Mar","flight","Santiago"); ?> must be different edges). Conversely, under No Unique Name Assumption (NUNA), we can only say that there is <em>at least one</em> such flight since <span class="ginode">Viña&nbsp;del&nbsp;Mar</span> and <span class="ginode">Arica</span> may be the same entity with two “names”.</p>
		<p>These assumptions (or lack thereof) define which interpretations are valid, and which interpretations <em>satisfy</em> which data graphs. The UNA forbids interpretations that map two data terms to the same domain term. The NUNA allows such interpretations. Under CWA, an interpretation that contains an edge <? echo giedge("x","p","y"); ?> in its domain graph can only satisfy a data graph from which we can entail <? echo gedge("x","p","y"); ?>. Under OWA, an interpretation containing the edge <? echo giedge("x","p","y"); ?> can satisfy a data graph not entailing <? echo gedge("x","p","y"); ?> so long it does not contradict that edge.<? echo footnote("Variations of the CWA can provide a middle ground between a completely open world that makes no assumption about completeness, falsehood of unknown statements, or unicity of names. One example of such variation is Local Closed World Assumption, already mentioned in Section&nbsp;". ref("sec:semSchema") ."."); ?> In the case of OWL, the NUNA and OWA are adopted, thus representing the most general case, whereby multiple nodes/edge-labels in the graph may refer to the same entity/relation-type (NUNA), and where anything not entailed by the data graph is <em>not</em> assumed to be false as a consequence (OWA).</p>
		<p>Beyond our base assumptions, we can associate certain patterns in the data graph with <em>semantic conditions</em> that define which interpretations satisfy it; for example, we can add a semantic condition to enforce that if our data graph contains the edge <? echo gedge("p","subp.&nbsp;of","q"); ?>, then any edge <? echo giedge("x","p","y"); ?> in the domain graph of the interpretation must also have a corresponding edge <? echo giedge("x","q","y"); ?> to satisfy the data graph. These semantic conditions then form the features of an ontology language. In what follows, to aid readability, we will introduce the features of OWL using an abstract graphical notation with abbreviated terms. For details of concrete syntaxes, we rather refer to the OWL and OBOF standards&nbsp;<? echo $references->cite("OWL2,obof"); ?>. Likewise we present semantic conditions for interpretations associated with each feature in the same graphical format;<? echo footnote("We use “iff” as an abbreviation for “if and only if” whereby “\\(\\phi\\) iff \\(\\psi\\)” can be read as “if \\(\\phi\\) then \\(\\psi\\)” and “if \\(\\psi\\) then \\(\\phi\\)”."); ?> further details of these conditions will be described later in Section&nbsp;<? echo ref("sec:ontSemantics"); ?>.</p>

		<div class="formal">
			<p>A graph interpretation – or simply interpretation – captures the assumptions under which the semantics of a graph can be defined. We define interpretations for directed edge-labelled graphs, though the notion extends naturally to other graph models.</p>

			<dl class="definition" id="def-graph-interpretation">
				<dt>Graph interpretation</dt>
				<dd>A <em>(graph) interpretation</em> \(I\) is defined as a pair \(I \coloneqq (\Gamma,\inp{\cdot})\) where \(\Gamma = (V_\Gamma,E_\Gamma,L_\Gamma)\) is a (directed edge-labelled) graph called the <em>domain graph</em> and \(\inp{\cdot} : \con \rightarrow V_\Gamma \cup L_\Gamma\) is a partial mapping from constants to terms in the domain graph. </dd>
			</dl>

			<p>We denote the domain of the mapping \(\inp{\cdot}\) by \(\textrm{dom}(\inp{\cdot})\). For interpretations under the UNA, the mapping \(\inp{\cdot}\) is required to be injective, while with no UNA (NUNA), no such requirement is necessary. Interpretations that <em>satisfy</em> a graph are then said to be <em>models</em> of that graph. We first define this notion for a base case that ignores ontological features.</p>

			<dl class="definition" id="def-graph-models">
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

			<p>Next we define models under semantics conditions (e.g., of ontology features).</p>

			<dl class="definition" id="def-semantic-condition">
				<dt>Semantic condition</dt>
				<dd>Let \(2^G\) denote the set of all (directed edge-labelled) graphs. A <em>semantic condition</em> is a mapping \(\phi : 2^{G} \rightarrow \{ \text{true}, \text{false} \}\). An interpretation \(I \coloneqq (\Gamma,\inp{\cdot})\) is a model of \(G\) under \(\phi\) if and only if \(I\) is a model of \(G\) and \(\phi(\Gamma)\). Given a set of semantic conditions \(\Phi\), we say that \(I\) is a model of \(G\) if and only if \(I\) is a model of \(G\) and for all \(\phi \in \Phi\), \(\phi(\Gamma)\) is true.</dd>
			</dl>

			<p>We do not restrict the language used to define semantic conditions, but, for example, we can define the <span class="sc">Has Value</span> semantic condition of Table&nbsp;<? echo ref("tab:ontClass"); ?> in FOL as follows:</p>
			<p class="mathblock">\(\forall c, p, y \Big( \big( \Gamma(c,\)<span class="gielab">prop</span>\(,p) \wedge \Gamma(c,\)<span class="gielab">value</span>\(,y) \big) \leftrightarrow \forall x \big( \Gamma(x,\)<span class="gielab">type</span>\(,c) \leftrightarrow \Gamma(x,p,y) \big) \Big)\)</p>
			<p>Here we overload \(\Gamma\) as a ternary predicate to capture the edges of \(\Gamma\). The above FOL formula defines an if-and-only-if version of the semantic condition for <span class="sc">Has Value</span>. The other semantic conditions enumerated in Tables&nbsp;<? echo ref("tab:ontEqIneq"); ?>–<? echo ref("tab:ontClass"); ?> can be defined in a similar way&nbsp;<? echo $references->cite("SchneiderS11"); ?>.<? echo footnote("Note that although these tables consider axioms originating in the data graph, it suffices to check their image in the domain graph since \(I\) only satisfies \(G\) if the edges of \(G\) defining the axioms are reflected in \(I\)."); ?></p>
		</div>

		<h4 id="sssec-individuals" class="subsection">Individuals</h4>
		<p>In Table&nbsp;<? echo ref("tab:ontEqIneq"); ?>, we list the main features supported by OWL for describing <em>individuals</em> (e.g., <span class="sf">Santiago</span>, <span class="sf">EID16</span>), sometimes distinguished from classes and properties. First, we can <em>assert</em> (binary) relations between individuals using edges such as <? echo gedge("Santa&nbsp;Lucía","city","Santiago"); ?>. In the condition column, when we write <? echo giedge("\\(x\\)","\\(y\\)","\\(z\\)"); ?>, for example, we refer to the condition that the given relation holds in the interpretation; if so, the interpretation <em>satisfies</em> the axiom. OWL further allows for defining relations to explicitly state that two terms refer to the <em>same</em> entity, where, e.g., <? echo gedge("Región&nbsp;V","same&nbsp;as","Región de Valparaíso"); ?> states that both refer to the same region (per Section&nbsp;<? echo ref("sec:identity"); ?>); or that two terms refer to <em>different</em> entities, where, e.g., <? echo gedge("Valparaíso","diff.&nbsp;from","Región&nbsp;de&nbsp;Valparaíso"); ?> distinguishes the city from the region of the same name. We may also state that a relation does not hold using <em>negation</em>, which can be serialised as a graph using a form of reification (see Figure&nbsp;<? echo ref("fig:reif"); ?>).</p>

		<table class="normalTable" id="tab-ontEqIneq">
			<caption>Ontology features for individuals</caption>
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
					<td><? echo gedge("\\(x\\)","\\(y\\)","\\(z\\)"); ?></td>
					<td><? echo giedge("\\(x\\)","\\(y\\)","\\(z\\)"); ?></td>
					<td><? echo gedge("City","capital","Santiago"); ?></td>
				</tr>
				<tr>
					<td>Negation</td>
					<td><img class="inside" src="images/tab-ontEqIneq-neg-axiom.svg" alt="negation axiom" /></td>
					<td>not <? echo giedge("\\(x\\)","\\(y\\)","\\(z\\)"); ?></td>
					<td><img class="inside" src="images/tab-ontEqIneq-neg-example.svg" alt="negation example" /></td>
				</tr>
				<tr>
					<td>Same As</td>
					<td><? echo gedge("\\(x_1\\)","same&nbsp;as","\\(x_2\\)"); ?></td>
					<td><span class="ginode">\(x_1\)</span> = <span class="ginode">\(x_2\)</span></td>
					<td><? echo gedge("Región&nbsp;V","same&nbsp;as","Región&nbsp;de&nbsp;Valparaíso"); ?></td>
				</tr>
				<tr>
					<td>Different From</td>
					<td><? echo gedge("\\(x_1\\)","diff.&nbsp;from","\\(x_2\\)"); ?></td>
					<td><span class="ginode">\(x_1\)</span> ≠ <span class="ginode">\(x_2\)</span></td>
					<td><? echo gedge("Valparaíso","diff.&nbsp;from","Región&nbsp;de&nbsp;Valparaíso"); ?></td>
				</tr>
			</tbody>
		</table>

		<h4 id="sssec-properties" class="subsection">Properties</h4>
		<p>In Section&nbsp;<? echo ref("sec:semSchema"); ?>, we already discussed how <em>subproperties</em>, <em>domains</em> and <em>ranges</em> may be defined for properties. OWL allows such definitions, and further includes other features, as listed in Table&nbsp;<? echo ref("tab:ontProp"); ?>. We may define a pair of properties to be <em>equivalent</em>, <em>inverses</em>, or <em>disjoint</em>. We can further define a particular property to denote a <em>transitive</em>, <em>symmetric</em>, <em>asymmetric</em>, <em>reflexive</em>, or <em>irreflexive</em> relation. We can also define the multiplicity of the relation denoted by properties, based on being <em>functional</em> (many-to-one) or <em>inverse-functional</em> (one-to-many). We may further define a <em>key</em> for a class, denoting the set of properties whose values uniquely identify the entities of that class. Without adopting a Unique Name Assumption (UNA), from these latter three features we may conclude that two or more terms refer to the same entity. Finally, we can relate a property to a <em>chain</em> (a path expression only allowing concatenation of properties) such that pairs of entities related by the chain are also related by the given property. Note that for the latter two features in Table&nbsp;<? echo ref("tab:ontProp"); ?> we require representing a list, denoted with a vertical notation <span class="gnode">⋮</span>; while such a list may be serialised as a graph in a number of concrete ways, OWL uses RDF lists (see Figure&nbsp;<? echo ref("fig:list"); ?>).</p>

		<table class="normalTable" id="tab-ontProp">
			<caption>Ontology features for property axioms</caption>
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
					<td>Subproperty</td>
					<td><? echo gedge("\\(p\\)","subp.&nbsp;of","\\(q\\)"); ?></td>
					<td><? echo giedge("\\(x\\)","\\(p\\)","\\(y\\)"); ?> implies <? echo giedge("\\(x\\)","\\(q\\)","\\(y\\)"); ?></td>
					<td><? echo gedge("venue","subp.&nbsp;of","location"); ?></td>
				</tr>
				<tr>
					<td>Domain</td>
					<td><? echo gedge("\\(p\\)","domain","\\(c\\)"); ?></td>
					<td><? echo giedge("\\(x\\)","\\(p\\)","\\(y\\)"); ?> implies <? echo giedge("\\(x\\)","type","\\(c\\)"); ?></td>
					<td><? echo gedge("venue","domain","Event"); ?></td>
				</tr>
				<tr>
					<td>Range</td>
					<td><? echo gedge("\\(p\\)","range","\\(c\\)"); ?></td>
					<td><? echo giedge("\\(x\\)","\\(p\\)","\\(y\\)"); ?> implies <? echo giedge("\\(y\\)","type","\\(c\\)"); ?></td>
					<td><? echo gedge("venue","range","Venue"); ?></td>
				</tr>
				<tr>
					<td>Equivalence</td>
					<td><? echo gedge("\\(p\\)","equiv.&nbsp;p.","\\(q\\)"); ?></td>
					<td><? echo giedge("\\(x\\)","\\(p\\)","\\(y\\)"); ?> iff <? echo giedge("\\(x\\)","\\(q\\)","\\(y\\)"); ?></td>
					<td><? echo gedge("start","equiv.&nbsp;p.","begins"); ?></td>
				</tr>
				<tr>
					<td>Inverse</td>
					<td><? echo gedge("\\(p\\)","inv.&nbsp;of","\\(q\\)"); ?></td>
					<td><? echo giedge("\\(x\\)","\\(p\\)","\\(y\\)"); ?> iff <? echo giedge("\\(y\\)","\\(q\\)","\\(x\\)"); ?></td>
					<td><? echo gedge("venue","inv.&nbsp;of","hosts"); ?></td>
				</tr>
				<tr>
					<td>Disjoint</td>
					<td><? echo gedge("\\(p\\)","disj.&nbsp;p.","\\(q\\)"); ?></td>
					<td>not <img class="inside" src="images/tab-ontProp-disj-cond.svg" alt="disjoint condition" /></td>
					<td><? echo gedge("venue","disj.&nbsp;p.","hosts"); ?></td>
				</tr>
				<tr>
					<td>Transitive</td>
					<td><? echo gedge("\\(p\\)","type","Transitive"); ?></td>
					<td><? echo giedge("\\(x\\)","\\(p\\)","\\(y\\)"); ?><? echo isource(); ?><span class="iedge">\(p\)</span><? echo itipr(); ?><span class="ginode">\(z\)</span><br/>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; implies <? echo giedge("\\(x\\)","\\(p\\)","\\(z\\)"); ?></td>
					<td><? echo gedge("part&nbsp;of","type","Transitive"); ?></td>
				</tr>
				<tr>
					<td>Symmetric</td>
					<td><? echo gedge("\\(p\\)","type","Symmetric"); ?></td>
					<td><? echo giedge("\\(x\\)","\\(p\\)","\\(y\\)"); ?> iff <? echo giedge("\\(y\\)","\\(p\\)","\\(x\\)"); ?></td>
					<td><? echo gedge("nearby","type","Symmetric"); ?></td>
				</tr>
				<tr>
					<td>Asymmetric</td>
					<td><? echo gedge("\\(p\\)","type","Asymmetric"); ?></td>
					<td>not <img class="inside" src="images/tab-ontProp-asym-cond.svg" alt="asymmetric condition" /></td>
					<td><? echo gedge("capital","type","Asymmetric"); ?></td>
				</tr>
				<tr>
					<td>Reflexive</td>
					<td><? echo gedge("\\(p\\)","type","Reflexive"); ?></td>
					<td><img class="inside" src="images/tab-ontProp-refl-cond.svg" alt="reflexive condition" /></td>
					<td><? echo gedge("part&nbsp;of","type","Reflexive"); ?></td>
				</tr>
				<tr>
					<td>Irreflexive</td>
					<td><? echo gedge("\\(p\\)","type","Irreflexive"); ?></td>
					<td>not <img class="inside" src="images/tab-ontProp-refl-cond.svg" alt="irreflexive condition" /></td>
					<td><? echo gedge("flight","type","Irreflexive"); ?></td>
				</tr>
				<tr>
					<td>Functional</td>
					<td><? echo gedge("\\(p\\)","type","Functional"); ?></td>
					<td><span class="ginode">\(y_1\)</span><? echo itipl(); ?><span class="iedge">\(p\)</span><? echo isource(); ?><? echo giedge("\\(x\\)","\\(p\\)","\\(y_2\\)"); ?><br/>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; implies <span class="ginode">\(y_1\)</span> = <span class="ginode">\(y_2\)</span></td>
					<td><? echo gedge("population","type","Functional"); ?></td>
				</tr>
				<tr>
					<td>Inv. Functional</td>
					<td><? echo gedge("\\(p\\)","type","Inv.&nbsp;Functional"); ?></td>
					<td><? echo giedge("\\(x_1\\)","\\(p\\)","\\(y\\)"); ?><? echo itipl(); ?><span class="iedge">\(p\)</span><? echo isource(); ?><span class="ginode">\(x_2\)</span><br/>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; implies <span class="ginode">\(x_1\)</span> = <span class="ginode">\(x_2\)</span></td>
					<td><? echo gedge("capital","type","Inv.&nbsp;Functional"); ?></td>
				</tr>
				<tr>
					<td>Key</td>
					<td><span class="gnode">\(c\)</span><? echo esource(); ?><span class="edge">key</span><? echo etipr(); ?><span class="gnode stack-tab">\(p_1\)<br/>⋮<br/>\(p_n\)</span></td>
					<td><img style="margin-left:0;" class="inside" src="images/tab-ontProp-key-cond.svg" alt="key condition premise" />&thinsp;implies&thinsp;<span class="ginode">\(x_1\)</span>=<span class="ginode">\(x_2\)</span></td>
					<td><span class="gnode">City</span><? echo esource(); ?><span class="edge">key</span><? echo etipr(); ?><span class="gnode stack-tab">lat<br/>long</span></td>
				</tr>
				<tr>
					<td>Chain</td>
					<td><span class="gnode">\(p\)</span><? echo esource(); ?><span class="edge">chain</span><? echo etipr(); ?><span class="gnode stack-tab">\(q_1\)<br/>⋮<br/>\(q_n\)</span></td>
					<td><? echo giedge("\\(x\\)","\\(q_1\\)","\\(y_1\\)"); ?><? echo isource(); ?>…<? echo itipr(); ?><? echo giedge("\\(y_{n-1}\\)","\\(q_n\\)","\\(z\\)"); ?><br/>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; implies <? echo giedge("\\(x\\)","\\(p\\)","\\(z\\)"); ?></td>
					<td><span class="gnode">location</span><? echo esource(); ?><span class="edge">chain</span><? echo etipr(); ?><span class="gnode stack-tab">location<br/>part&nbsp;of</span></td>
				</tr>
			</tbody>
		</table>

		<h4 id="sssec-classes" class="subsection">Classes</h4>
		<p>In Section&nbsp;<? echo ref("sec:semSchema"); ?>, we discussed how class hierarchies can be modelled using a <em>sub-class</em> relation. OWL supports sub-classes, and many additional features, for defining and making claims about classes; these additional features are summarised in Table&nbsp;<? echo ref("tab:ontClass"); ?>. Given a pair of classes, OWL allows for defining that they are <em>equivalent</em>, or <em>disjoint</em>. Thereafter, OWL provides a variety of features for defining novel classes by applying set operators on other classes, or based on conditions that the properties of its instances satisfy. First, using set operators, one can define a novel class as the <em>complement</em> of another class, the <em>union</em> or <em>intersection</em> of a list (of arbitrary length) of other classes, or as an <em>enumeration</em> of all of its instances. Second, by placing restrictions on a particular property \(p\), one can define classes whose instances are all of the entities that have: <em>some value</em> from a given class on \(p\); <em>all values</em> from a given class on \(p\);<? echo footnote("While something like <span class=\"gnode\">flight</span>". etipl() ."<span class=\"edge\">prop</span>". esource() . gedge("DomesticAirport","all","NationalFlight") ." might appear to be a more natural example for <span class=\"sc\">All Values</span>, this would be a modelling mistake, as the corresponding <em>for all</em> condition is satisfied when no such node exists. In other words, with this example definition, we could infer anything known not to have any flights to be a domestic airport. (We could, however, define the intersection of this class and airport as being a domestic airport.)"); ?> have a specific individual as a value on \(p\) (<em>has value</em>); have themselves as a reflexive value on \(p\) (<em>has self</em>); have at least, at most or exactly some number of values on \(p\) (<em>cardinality</em>); and have at least, at most or exactly some number of values on \(p\) from a given class (<em>qualified cardinality</em>). For the latter two cases, in Table&nbsp;<? echo ref("tab:ontClass"); ?>, we use the notation “\(\#\{\)<span class="ginode">a</span>\(\mid \phi \}\)” to count distinct entities satisfying \(\phi\) in the interpretation. These features can then be combined to create more complex classes, where combining the examples for <span class="sc">Intersection</span> and <span class="sc">Has Self</span> in Table&nbsp;<? echo ref("tab:ontClass"); ?> gives the definition: <em>self-driving taxis are taxis having themselves as a driver</em>.</p>

		<table class="normalTable" id="tab-ontClass">
			<caption>Ontology features for class axioms and definitions</caption>
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
					<td>Subclass</td>
					<td><? echo gedge("\\(c\\)","subc.&nbsp;of","\\(d\\)"); ?></td>
					<td><? echo giedge("\\(x\\)","type","\\(c\\)"); ?> implies <? echo giedge("\\(x\\)","type","\\(d\\)"); ?></td>
					<td><? echo gedge("City","subc.&nbsp;of","Place"); ?></td>
				</tr>
				<tr>
					<td>Equivalence</td>
					<td><? echo gedge("\\(c\\)","equiv.&nbsp;c.","\\(d\\)"); ?></td>
					<td><? echo giedge("\\(x\\)","type","\\(c\\)"); ?> iff <? echo giedge("\\(x\\)","type","\\(d\\)"); ?></td>
					<td><? echo gedge("Human","suc.&nbsp;of","Person"); ?></td>
				</tr>
				<tr>
					<td>Disjoint</td>
					<td><? echo gedge("\\(c\\)","disj.&nbsp;c.","\\(d\\)"); ?></td>
					<td>not <span class="ginode">\(c\)</span><? echo itipl(); ?><span class="iedge">type</span><? echo isource(); ?><? echo giedge("\\(x\\)","type","\\(d\\)"); ?></td>
					<td><? echo gedge("City","disj.&nbsp;c.","Region"); ?></td>
				</tr>
				<tr>
					<td>Complement</td>
					<td><? echo gedge("\\(c\\)","comp.","\\(d\\)"); ?></td>
					<td><? echo giedge("\\(x\\)","type","\\(c\\)"); ?> iff not <? echo giedge("\\(x\\)","type","\\(d\\)"); ?></td>
					<td><? echo gedge("Dead","com.","Alive"); ?></td>
				</tr>
				<tr>
					<td>Union</td>
					<td><span class="gnode">\(c\)</span><? echo esource(); ?><span class="edge">union</span><? echo etipr(); ?><span class="gnode stack-tab">\(d_1\)<br/>⋮<br/>\(d_n\)</span></td>
					<td><? echo giedge("\\(x\\)","type","\\(c\\)"); ?> iff <div class="stack-tab"><? echo giedge("\\(x\\)","type","\\(d_1\\)"); ?> or<br/><? echo giedge("\\(x\\)","type","…"); ?> or<br/><? echo giedge("\\(x\\)","type","\\(d_n\\)"); ?></div></td>
					<td><span class="gnode">Flight</span><? echo esource(); ?><span class="edge">union</span><? echo etipr(); ?><span class="gnode stack-tab">DomesticFlight<br/>InternationalFlight</span></td>
				</tr>
				<tr>
					<td>Intersection</td>
					<td><span class="gnode">\(c\)</span><? echo esource(); ?><span class="edge">inter.</span><? echo etipr(); ?><span class="gnode stack-tab">\(d_1\)<br/>⋮<br/>\(d_n\)</span></td>
					<td><? echo giedge("\\(x\\)","type","\\(c\\)"); ?> iff <img class="inside" src="images/tab-ontClass-inter-cond.svg" alt="intersection condition equiv" /></td>
					<td><span class="gnode">SelfDrivingTaxi</span><? echo esource(); ?><span class="edge">inter.</span><? echo etipr(); ?><span class="gnode stack-tab">Taxi<br/>SelfDriving</span></td>
				</tr>
				<tr>
					<td>Enumeration</td>
					<td><span class="gnode">\(c\)</span><? echo esource(); ?><span class="edge">one&nbsp;of</span><? echo etipr(); ?><span class="gnode stack-tab">\(x_1\)<br/>⋮<br/>\(x_n\)</span></td>
					<td><? echo giedge("\\(x\\)","type","\\(c\\)"); ?> iff <span class="ginode">\(x\)</span> \(\in \{\)<span class="ginode">\(x_1\)</span>\(,\dots,\)<span class="ginode">\(x_n\)</span>\(\}\)</td>
					<td><span class="gnode">EUState</span><? echo esource(); ?><span class="edge">one&nbsp;of</span><? echo etipr(); ?><span class="gnode stack-tab">Austria<br/>⋮<br/>Sweden</span></td>
				</tr>
				<tr>
					<td>Some Values</td>
					<td><img class="inside" src="images/tab-ontClass-someval-axiom.svg" alt="some values axiom" /></td>
					<td><? echo giedge("\\(x\\)","type","\\(c\\)"); ?> iff <div class="stack-tab">there exists <span class="ginode">\(a\)</span> such that<br/><? echo giedge("\\(x\\)","\\(p\\)","\\(a\\)"); ?><? echo isource(); ?><span class="iedge">type</span><? echo itipr(); ?><span class="ginode">\(d\)</span></div></td>
					<td><img class="inside" src="images/tab-ontClass-someval-example.svg" alt="some values example" /></td>
				</tr>
				<tr>
					<td>All Values</td>
					<td><img class="inside" src="images/tab-ontClass-allval-axiom.svg" alt="all values axiom" /></td>
					<td><? echo giedge("\\(x\\)","type","\\(c\\)"); ?> iff <div class="stack-tab">for all <span class="ginode">\(a\)</span> with <? echo giedge("\\(x\\)","\\(p\\)","\\(a\\)"); ?><br/>it holds that <? echo giedge("\\(a\\)","type","\\(d\\)"); ?></div></td>
					<td><img class="inside" src="images/tab-ontClass-allval-example.svg" alt="all values example" /></td>
				</tr>
				<tr>
					<td>Has Value</td>
					<td><img class="inside" src="images/tab-ontClass-hasval-axiom.svg" alt="has value axiom" /></td>
					<td><? echo giedge("\\(x\\)","type","\\(c\\)"); ?> iff <? echo giedge("\\(x\\)","\\(p\\)","\\(y\\)"); ?></td>
					<td><img class="inside" src="images/tab-ontClass-hasval-example.svg" alt="has value example" /></td>
				</tr>
				<tr>
					<td>Has Self</td>
					<td><img class="inside" src="images/tab-ontClass-hasself-axiom.svg" alt="has self axiom" /></td>
					<td><? echo giedge("\\(x\\)","type","\\(c\\)"); ?> iff <? echo giedge("\\(x\\)","\\(p\\)","\\(x\\)"); ?></td>
					<td><img class="inside" src="images/tab-ontClass-hasself-example.svg" alt="has self example" /></td>
				</tr>
				<tr>
					<td>Cardinality<br/>\(\star \in \{ =, \leq, \geq \}\)</td>
					<td><img class="inside" src="images/tab-ontClass-card-axiom.svg" alt="cardinality axiom" /></td>
					<td><? echo giedge("\\(x\\)","type","\\(c\\)"); ?><br/>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; iff \(\#\{\)<span class="ginode">a</span> \(\mid\) <? echo giedge("\\(x\\)","\\(p\\)","\\(a\\)"); ?>\(\} \star n\)</td>
					<td><img class="inside" src="images/tab-ontClass-card-example.svg" alt="cardinality example" /></td>
				</tr>
				<tr>
					<td>Qualified<br/>Cardinality<br/>\(\star \in \{ =, \leq, \geq \}\)</td>
					<td><img class="inside" src="images/tab-ontClass-qualcard-axiom.svg" alt="qualified cardinality axiom" /></td>
					<td><? echo giedge("\\(x\\)","type","\\(c\\)"); ?><br/>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; iff \(\#\{\)<span class="ginode">a</span> \(\mid\) <? echo giedge("\\(x\\)","\\(p\\)","\\(a\\)"); ?><? echo isource(); ?><span class="iedge">type</span><? echo itipr(); ?><span class="ginode">\(d\)</span>\(\} \star n\)</td>
					<td><img class="inside" src="images/tab-ontClass-qualcard-example.svg" alt="qualified cardinality example" /></td>
				</tr>
			</tbody>
		</table>

		<h4 id="sssec-other-features" class="subsection">Other features</h4>
		<p>OWL supports other language features not previously discussed, including: <em>annotation properties</em>, which provide metadata about ontologies, such as versioning info; <em>datatype vs.&nbsp;object properties</em>, which distinguish properties that take datatype values from those that do not; and <em>datatype facets</em>, which allow for defining new datatypes by applying restrictions to existing datatypes, such as to define that places in Chile must have a <em>float between \(-66.0\) and \(-110.0\)</em> as their value for the (datatype) property <span class="gelab">latitude</span>. For more details we refer to the OWL 2 standard&nbsp;<? echo $references->cite("OWL2"); ?>. We will further discuss methodologies for the creation of ontologies in Section&nbsp;<? echo ref("ssec:knowledgeConceptual"); ?>.</p>
		</section>

		<section id="sec-ontSemantics" class="section">
		<h3>Semantics and Entailment</h3>
		<p>The conditions listed in the previous tables indicate how each feature should be interpreted. These conditions give rise to <em>entailments</em>, where, for example, in reference to the <span class="sc">Symmetric</span> feature of Table&nbsp;<? echo ref("tab:ontProp"); ?>, the definition <? echo gedge("nearby","type","Symmetric"); ?> and edge <? echo gedge("Santiago","nearby","Santiago&nbsp;Airport"); ?> entail the edge <? echo gedge("Santiago&nbsp;Airport","nearby","Santiago"); ?> according to the condition given for that feature. We now describe how these conditions lead to entailments.</p>

		<h4 id="sssec-model-theory" class="subsection">Model-theoretic semantics</h4>
		<p>Each axiom described by the previous tables, when added to a graph, enforces some condition(s) on the interpretations that <em>satisfy</em> the graph. The interpretations that satisfy a graph are called <em>models</em> of the graph. Were we to consider only the base condition of the <span class="sc">Assertion</span> feature in Table&nbsp;<? echo ref("tab:ontEqIneq"); ?>, for example, then the models of a graph would be any interpretation such that for every edge <? echo gedge("x","y","z"); ?> in the graph, there exists a relation <? echo giedge("x","y","z"); ?> in the model. Given that there may be other relations in the model (under the OWA), the number of models of any such graph is infinite. Furthermore, given that we can map multiple nodes in the graph to one entity in the model (under the NUNA), any interpretation with (for example) the relation <? echo giedge("a","a","a"); ?> is a model of any graph so long as for every edge <? echo gedge("x","y","z"); ?> in the graph, it holds that <span class="ginode">x</span> = <span class="ginode">y</span> = <span class="ginode">z</span> = <span class="ginode">a</span> in the interpretation (in other words, the interpretation maps everything to <span class="ginode">a</span>). As we add axioms with their associated conditions to the graph, we restrict models for the graph; for example, considering a graph with two edges – <? echo gedge("x","y","z"); ?> and <? echo gedge("y","type","Irreflexive"); ?> – the interpretation with <? echo giedge("a","a","a"); ?>, <span class="ginode">x</span> = <span class="ginode">y</span> = … = <span class="ginode">a</span> is no longer a model as it breaks the condition for the irreflexive axiom.</p>

		<h4 id="sssec-entailment" class="subsection">Entailment</h4>
		<p>We say that one graph <em>entails</em> another if and only if any model of the former graph is also a model of the latter graph. Intuitively this means that the latter graph says nothing new over the former graph and thus holds as a logical consequence of the former graph. For example, consider the graph <? echo gedge("Santiago","type","City"); ?><? echo esource(); ?><span class="edge">subc.&nbsp;of</span><? echo etipr(); ?><span class="gnode">Place</span> and the graph <? echo gedge("Santiago","type","Place"); ?>. All models of the latter must have that <? echo giedge("Santiago","type","Place"); ?>, but so must all models of the former, which must have <? echo giedge("Santiago","type","City"); ?><? echo isource(); ?><span class="iedge">subc.&nbsp;of</span><? echo itipr(); ?><span class="ginode">Place</span> and further must satisfy the condition for <span class="sc">Subclass</span>, which requires that <? echo giedge("Santiago","type","Place"); ?> also hold. Hence we conclude that any model of the former graph must be a model of the latter graph, or, in other words, the former graph entails the latter graph.</p>

		<div class="formal">
			<p>We now formally define entailment under semantic conditions.</p>

			<dl class="definition" id="def-ent">
				<dt>Graph entailment</dt>
				<dd>Letting \(G_1\) and \(G_2\) denote two (directed edge-labelled) graphs, and \(\Phi\) a set of semantic conditions, we say that <em>\(G_1\) entails \(G_2\) under \(\Phi\)</em> – denoted \(G_1 \models_\Phi G_2\) – if and only if any model of \(G_2\) under \(\Phi\) is also a model of \(G_1\) under \(\Phi\).</dd>
			</dl>

			<p>An example of entailment is discussed in Section&nbsp;<? echo ref("sec:ontSemantics"); ?>. Note that in a slight abuse of notation, we may simply write \(G \models_\Phi (s,p,o)\) to denote that \(G\) entails the edge \((s,p,o)\) under \(\Phi\).</p>
			<p>Under OWA, entailment is as defined as given in Definition&nbsp;<? echo ref("def:ent"); ?>. Under CWA, we make the additional assumption that if \(G \not\models_\Phi e\), where \(e\) is an edge (strictly speaking, a <em>positive</em> edge), then \(G \models_\Phi \neg e\); in other words, under CWA we assume that any (positive) edges that \(G\) does not entail under \(\Phi\) can be assumed false according to \(G\) and \(\Phi\).<? echo footnote("In FOL, the CWA only applies to positive <em>facts</em>, whereas edges in a graph can be used to represent other FOL formulae. If one wished to maintain FOL-compatibility under CWA, additional restrictions on the types of edge \\(e\\) may be needed."); ?></p>
		</div>

		<h4 id="sssec-if-then" class="subsection">If–then vs. if-and-only-if semantics</h4>
		<p>Consider the graph <? echo gedge("nearby","type","Symmetric"); ?> and the graph <? echo gedge("nearby","inv.&nbsp;of","nearby"); ?>. They result in the same semantic conditions being applied in the domain graph, but does one entail the other? The answer depends on the semantics applied. Considering the axioms and conditions of Tables&nbsp;<? echo ref("tab:ontEqIneq"); ?>, we can consider two semantics. Under if–then semantics – <span class="sc">if</span> <strong>Axiom</strong> matches data graph <span class="sc">then</span> <strong>Condition</strong> holds in domain graph – the graphs do not entail each other: though both graphs give rise to the same condition, this condition is not translated back into the axioms that describe it.<? echo footnote("Observe that ".giedge("nearby","type","Symmetric") ." is a model of the first graph but not the second, while ". giedge("nearby","inv.&nbsp;of","nearby") ." is a model of the second graph but not the first. Hence neither graph entails the other."); ?> Conversely, under if-and-only-if semantics – <strong>Axiom</strong> matches data graph <span class="sc">if-and-only-if</span> <strong>Condition</strong> holds in domain graph – the graphs entail each other: both graphs give rise to the same condition, which is translated back into all possible axioms that describe it. Hence if-and-only-if semantics allows for entailing more axioms in the ontology language than if–then semantics. OWL generally applies an if-and-only-if semantics&nbsp;<? echo $references->cite("OWL2"); ?>.</p>
		</section>

		<section id="ssec-reasoning" class="section">
		<h3>Reasoning</h3>
		<p>Unfortunately, given two graphs, deciding if the first entails the second – per the notion of entailment we have defined and for all of the ontological features listed in Tables&nbsp;<? echo ref("tab:ontEqIneq"). "–" .ref("tab:ontClass"); ?> – is <em>undecidable</em>: no (finite) algorithm for such entailment can exist that halts on all inputs with the correct <code>true</code>/<code>false</code> answer&nbsp;<? echo $references->cite("Hitzler2010"); ?>. However, we can provide practical reasoning algorithms for ontologies that (1) halt on any input ontology but may miss entailments, returning <code>false</code> instead of <code>true</code>, (2) always halt with the correct answer but only accept input ontologies with restricted features, or (3) only return correct answers for any input ontology but may never halt on certain inputs. Though option (3) has been explored using, e.g., theorem provers for First Order Logic&nbsp;<? echo $references->cite("SchneiderS11"); ?>, options (1) and (2) are more commonly pursued using rules and/or Description Logics. Option (1) generally allows for more efficient and scalable reasoning algorithms and is useful where data are incomplete and having some entailments is valuable. Option (2) may be a better choice in domains – such as medical ontologies – where missing entailments may have undesirable outcomes.</p>

		<h4 id="sec-rules" class="subsection">Rules</h4>
		<p>One of the most straightforward ways to provide automated access to deductive knowledge is through <em>inference rules</em> (or simply <em>rules</em>) encoding <span class="sc">if</span>–<span class="sc">then</span>-style consequences. A rule is composed of a <em>body</em> (<span class="sc">if</span>) and a <em>head</em> (<span class="sc">then</span>). Both the body and head are given as graph patterns. A rule indicates that if we can replace the variables of the body with terms from the data graph and form a subgraph of a given data graph, then using the same replacement of variables in the head will yield a valid entailment. The head must typically use a subset of the variables appearing in the body to ensure that the conclusion leaves no variables unreplaced. Rules of this form correspond to (positive) Datalog&nbsp;<? echo $references->cite("CeriGT89"); ?> in databases, Horn clauses&nbsp;<? echo $references->cite("lloyd2012foundations"); ?> in logic programming, etc.</p>
		<p>Rules can be used to capture entailments under ontological conditions. In Table&nbsp;<? echo ref("tab:rulesRdfs"); ?>, we list some example rules for sub-class, sub-property, domain and range features&nbsp;<? echo $references->cite("MunozPG09"); ?>; these rules may be considered incomplete, not capturing, for example, that every class is a sub-class of itself, that every property is a sub-property of itself, etc. A more comprehensive set of rules for the OWL features of Tables&nbsp;<? echo ref("tab:ontEqIneq"). "–" .ref("tab:ontClass"); ?> have been defined as OWL 2 RL/RDF&nbsp;<? echo $references->cite("key:owl2profiles"); ?>; these rules are likewise incomplete as such rules cannot fully capture negation (e.g., <span class="sc">Complement</span>), existentials (e.g., <span class="sc">Some Values</span>), universals (e.g., <span class="sc">All Values</span>), or counting (e.g., <span class="sc">Cardinality</span> and <span class="sc">Qualified Cardinality</span>). Other rule languages have, however, been proposed to support additional such features, including existentials (see, e.g., Datalog\(^\pm\)&nbsp;<? echo $references->cite("BellomariniSG18"); ?>), disjunction (see, e.g., Disjunctive Datalog&nbsp;<? echo $references->cite("RudolphKH08"); ?>), etc.</p>

		<table class="normalTable" id="tab-rulesRdfs">
			<caption>Example rules for sub-class, sub-property, domain, and range features</caption>
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
					<td>Subclass (I)</td>
					<td><? echo sedge("?x","type",NULL,"?c","gvar"); ?><? echo esource(); ?><span class="edge">subc.&nbsp;of</span><? echo etipr(); ?><span class="gvar">?d</span></td>
					<td>\(\Rightarrow\)</td>
					<td><? echo sedge("?x","type",NULL,"?d","gvar"); ?></td>
				</tr>
				<tr>
					<td>Subclass (II)</td>
					<td><? echo sedge("?d","subc.&nbsp;of",NULL,"?d","gvar"); ?><? echo esource(); ?><span class="edge">subc.&nbsp;of</span><? echo etipr(); ?><span class="gvar">?e</span></td>
					<td>\(\Rightarrow\)</td>
					<td><? echo sedge("?d","subc.&nbsp;of",NULL,"?e","gvar"); ?></td>
				</tr>
				<tr>
					<td>Subproperty (I)</td>
					<td><img class="inside" src="images/tab-rulesRdfs-subprop.svg" alt="subproprety (I) body" /></td>
					<td>\(\Rightarrow\)</td>
					<td><? echo sedge("?x","?q",NULL,"?y","gvar"); ?></td>
				</tr>
				<tr>
					<td>Subproperty (II)</td>
					<td><? echo sedge("?p","subp.&nbsp;of",NULL,"?q","gvar"); ?><? echo esource(); ?><span class="edge">subp.&nbsp;of</span><? echo etipr(); ?><span class="gvar">?r</span></td>
					<td>\(\Rightarrow\)</td>
					<td><? echo sedge("?p","subp.&nbsp;of",NULL,"?r","gvar"); ?></td>
				</tr>
				<tr>
					<td>Domain</td>
					<td><img class="inside" src="images/tab-rulesRdfs-domain.svg" alt="domain body" /></td>
					<td>\(\Rightarrow\)</td>
					<td><? echo sedge("?x","type",NULL,"?c","gvar"); ?></td>
				</tr>
				<tr>
					<td>Range</td>
					<td><img class="inside" src="images/tab-rulesRdfs-range.svg" alt="range body" /></td>
					<td>\(\Rightarrow\)</td>
					<td><? echo sedge("?y","type",NULL,"?c","gvar"); ?></td>
				</tr>
			</tbody>
		</table>

		<p>Rules can be leveraged for reasoning in a number of ways. <em>Materialisation</em> refers to the idea of applying rules recursively to a graph, adding the conclusions generated back to the graph until a fixpoint is reached and nothing more can be added. The materialised graph can then be treated as any other graph. Although the efficiency and scalability of materialisation can be enhanced through optimisations like Rete networks&nbsp;<? echo $references->cite("Forgy82"); ?>, or using distributed frameworks like MapReduce&nbsp;<? echo $references->cite("UrbaniKMHB12"); ?>, depending on the rules and the data, the materialised graph may become unfeasibly large to manage. Another strategy is to use rules for <em>query rewriting</em>, which given a query, will automatically extend the query in order to find solutions entailed by a set of rules; for example, taking the schema graph in Figure&nbsp;<? echo ref("fig:sg"); ?> and the rules in Table&nbsp;<? echo ref("tab:rulesRdfs"); ?>, the (sub-)pattern <span class="gvar">?x</span><? echo esource(); ?><span class="edge">type</span><? echo etipr(); ?><span class="gnode">Event</span> in a given input query would be rewritten to the following disjunctive pattern evaluated on the original graph:</p>

		<p class="mathblock"><span class="gvar">?x</span><? echo esource(); ?><span class="edge">type</span><? echo etipr(); ?><span class="gnode">Event</span> \(\cup\) <span class="gvar">?x</span><? echo esource(); ?><span class="edge">type</span><? echo etipr(); ?><span class="gnode">Type</span> \(\cup\) <span class="gvar">?x</span><? echo esource(); ?><span class="edge">type</span><? echo etipr(); ?><span class="gnode">Periodic&nbsp;Market</span> \(\cup\) <? echo sedge("?x","venue",NULL,"?y","gvar"); ?></p>

		<p>Figure&nbsp;<? echo ref("fig:qrew"); ?> provides a more complete example of an ontology that is used to rewrite the query of Figure&nbsp;<? echo ref("fig:bgpFS"); ?>; if evaluated over the graph of Figure&nbsp;<? echo ref("fig:delg"); ?>, <span class="gnode">Ñam</span> will be returned as a solution. However, not all of the aforementioned features of OWL can be supported in this manner. The OWL 2 QL profile&nbsp;<? echo $references->cite("key:owl2profiles"); ?> is a subset of OWL designed specifically for query rewriting of this form&nbsp;<? echo $references->cite("ArtaleCKZ09"); ?>.</p>

		<figure id="fig-qrew">
			<dl>
				<dt>\(O:\)</dt>
				<dd>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<img class="inlined" src="images/fig-qrew1.svg" alt="ontology"/></dd>
				<dt>\(Q(O):\)</dt>
				<dd>&nbsp;&nbsp;&nbsp;&nbsp;\((\)<img class="inlined" src="images/fig-qrew2.svg" alt="type Festival"/> \(\cup\) <img class="inlined" src="images/fig-qrew3.svg" alt="type Food Festival"/> \(\cup\) <img class="inlined" src="images/fig-qrew4.svg" alt="type Drinks Festival"/>\()\)</dd>
				<dd>\(\Join (\)<img class="inlined" src="images/fig-qrew5.svg" alt="location Santiago"/> \(\cup\) <img class="inlined" src="images/fig-qrew6.svg" alt="venue city Santiago"/>\()\)</dd>
				<dd>\(\Join \) &nbsp;<img class="inlined" src="images/fig-qrew7.svg" alt="name"/></dd>
			</dl>
			<figcaption>Query rewriting example for the query \(Q\) of Figure&nbsp;<? echo ref("fig:bgpFS"); ?></figcaption>
		</figure>

		<p>While rules can be used to (partially) capture ontological entailments, they can also be defined independently of an ontology language, capturing entailments for a given domain. In fact, some rules – such as the following – cannot be captured by the ontology features previously seen, as they do not support ways to infer relations from cyclical graph patterns (for computability reasons):</p>
		
		<p class="mathblock"><img class="inside" src="images/fig-inline-rule.svg" alt="dom flight rule premise" style="margin-right:2em;vertical-align:middle;position:relative;"/> \(\Rightarrow\) <? echo sedge("?x","domestic&nbsp;flight",NULL,"?y","gvar"); ?></p>

		<p>Various languages allow for expressing rules over graphs – independently or alongside of an ontology language – including: Notation3 (N3)&nbsp;<? echo $references->cite("n3"); ?>, Rule Interchange Format (RIF)&nbsp;<? echo $references->cite("rif"); ?>, Semantic Web Rule Language (SWRL)&nbsp;<? echo $references->cite("swrl"); ?>, and SPARQL Inferencing Notation (SPIN)&nbsp;<? echo $references->cite("spin"); ?>.</p>

		<div class="formal">
			<p>Given a graph pattern \(Q\) – be it a directed edge-labelled graph pattern per Definition&nbsp;<? echo ref("def:delgp"); ?> or a property graph pattern per Definition&nbsp;<? echo ref("def:pgp"); ?> – recall that \(\var(Q)\) denotes the variables appearing in \(Q\). We can now define the notion of a rule for graphs.</p>

			<dl class="definition" id="def-rule">
				<dt>Rule</dt>
				<dd>A <em>rule</em> is a pair \(R \coloneqq (B,H)\) such that \(B\) and \(H\) are graph patterns and \(\var(H) \subseteq B\). The graph pattern \(B\) is called the <em>body</em> of the rule while \(H\) is called the <em>head</em> of the rule. </dd>
			</dl>

			<p>This definition of a rule applies for directed edge-labelled graphs and property graphs by considering the corresponding type of graph pattern. The head is considered to be a conjunction of edges. Given a graph \(G\), a rule is <em>applied</em> by computing the mappings from the body to the graph and then using those mappings to substitute the variables in \(H\). The restriction \(\var(H) \subseteq B\) ensures that the results of this substitution is a graph, with no variables in \(H\) left unsubstituted.</p>

			<dl class="definition" id="def-rule-application">
				<dt>Rule application</dt>
				<dd>Given a rule \(R = (B,H)\) and a graph \(G\), we define the <em>application of \(R\) over \(G\)</em> as the graph \(R(G) \coloneqq \bigcup_{\mu \in B(G)} \mu(H)\).</dd>
			</dl>

			<p>Given a set of rules \(\mathcal{R} \coloneqq \{ R_1, \ldots R_n \}\) and a knowledge graph \(G\), towards defining the set of inferences given by the rules over the graph, we denote by \(\mathcal{R}(G) \coloneqq \bigcup_{R \in \mathcal{R}} R(G)\) the union of the application of all rules of \(\mathcal{R}\) over \(G\), and we denote by \(\mathcal{R}^+(G) \coloneqq \mathcal{R}(G) \cup G\) the extension of \(G\) with respect to the application of \(\mathcal{R}\). Finally, we denote by \(\mathcal{R}^k(G)\) (for \(k \in \mathbb{N^+}\)) the recursive application of \(\mathcal{R}^+(G)\), where \(\mathcal{R}^1(G) \coloneqq \mathcal{R}^+(G)\), and \(\mathcal{R}^{i+1}(G) \coloneqq \mathcal{R}^+(\mathcal{R}^{i}(G))\). We are now ready to define the <em>least model</em>, which captures the inferences possible for \(\mathcal{R}\) over \(G\).</p>

			<dl class="definition" id="def-least-model">
				<dt>Least model</dt>
				<dd>The <em>least model of \(\mathcal{R}\)</em> over \(G\)} is defined as \(\mathcal{R}^*(G) \coloneqq \bigcup_{k\in \mathbb{N}}(R^k(G))\).</dd>
			</dl>

			<p>At some point \(R^{k'}(G) = R^{k'+1}(G)\): the rule applications reach a fixpoint and we have the least model. Once the least model \(\mathcal{R}^*(G)\) is computed, the entailed data can be treated as any other data.</p>
			<p>Rules can be used to support graph entailments of the form \(G_1 \models_\Phi G_2\). We say that a set of rules \(\mathcal{R}\) is <em>correct</em> for \(\Phi\) if, for any graph \(G\), \(G \models_\Phi \mathcal{R}^*(G)\). We say that \(\mathcal{R}\) is <em>complete</em> for \(\Phi\) if, for any graph \(G\), there does not exist an edge \(e\) such that \(G \models_\Phi e\) and \(e \not\in \mathcal{R}^*(G)\). Table&nbsp;<? echo ref("tab:rulesRdfs"); ?> exemplifies a correct (but incomplete) set of rules for the semantic conditions laid out by the RDFS standard&nbsp;<? echo $references->cite("RDFS"); ?>.</p>
			<p>Alternatively, rules can be directly specified in a rule language such as Notation3 (N3)&nbsp;<? echo $references->cite("n3"); ?>, Rule Interchange Format (RIF)&nbsp;<? echo $references->cite("rif"); ?>, Semantic Web Rule Language (SWRL)&nbsp;<? echo $references->cite("swrl"); ?>, or SPARQL Inferencing Notation (SPIN)&nbsp;<? echo $references->cite("spin"); ?>. Languages such as SPIN represent rules as graphs, allowing the rules of a knowledge graph to be embedded in the data graph. Taking advantage of this fact, we can then consider a form of graph entailment \(G_1 \cup \gamma(\mathcal{R}) \models_\Phi G_2\), where by \(\gamma(\mathcal{R})\) we denote the graph representation of rules \(\mathcal{R}\). If the set of rules \(\mathcal{R}\) is correct and complete for \(\Phi\), we may simply write \(G_1 \cup \gamma(\mathcal{R}) \models G_2\), indicating that \(\Phi\) captures the same semantics for \(\gamma(\mathcal{R})\) as applying the rules in \(\mathcal{R}\); formally, \(G_1 \cup \gamma(\mathcal{R}) \models \mathcal{R}(G_1 \cup \gamma(\mathcal{R}))\) and there does not exist an edge \(e\) such that \(G_1 \cup \gamma(\mathcal{R}) \models e\) but \(e \not\in \mathcal{R}^*(G_1 \cup \gamma(\mathcal{R}))\). This allows us to view rules as another form of graph entailment.</p>
		</div>

		<h4 id="sssec-dls" class="subsection">Description Logics</h4>
		<p>Description Logics (DLs) were initially introduced as a way to formalise the meaning of <em>frames</em>&nbsp;<? $references->cite("minsky"); ?> and <em>semantic networks</em>&nbsp;<? $references->cite("quillian"); ?>. Considering that semantic networks are an early version of knowledge graphs, and the fact that DLs have heavily influenced the Web Ontology Language, DLs thus hold an important place in the logical formalisation of knowledge graphs. DLs form a family of logics rather than a particular logic. Initially, DLs were restricted fragments of First Order Logic (FOL) that permit decidable reasoning tasks, such as entailment checking&nbsp;<? echo $references->cite("BaaderHLS17"); ?>. Different DLs strike different balances between expressive power and computational complexity of reasoning. DLs would later be extended with features that go beyond FOL but are useful in the context of modelling graph data, such as transitive closure, datatypes, etc.</p>
		<p>Description Logics are based on three types of elements: <em>individuals</em>, such as <code>Santiago</code>; <em>classes</em> (aka <em>concepts</em>) such as <code>City</code>; and <em>properties</em> (aka <em>roles</em>) such as <code>flight</code>. DLs then allow for making claims, known as <em>axioms</em>, about these elements. <em>Assertional axioms</em> can be either unary class relations on individuals, such as <code>City(Santiago)</code>, or binary property relations on individuals, such as <code>flight(Santiago,Arica)</code>. Such axioms form the <em>Assertional Box</em> (<em>A-Box</em>). DLs further introduce logical symbols to allow for defining <em>class axioms</em> (forming the <em>Terminology Box</em>, or <em>T-Box</em> for short), and <em>property axioms</em> (forming the <em>Role Box</em>, <em>R-Box</em>); for example, the class axiom <span class="nobreak"><code>City</code>&nbsp;\(\sqsubseteq\)&nbsp;<code>Place</code></span> states that the former class is a subclass of the latter one, while the property axiom <span class="nobreak"><code>flight</code>&nbsp;\(\sqsubseteq\)&nbsp;<code>connectsTo</code></span> states that the former property is a subproperty of the latter one. DLs may then introduce a rich set of logical symbols, not only for defining class and property axioms, but also defining new classes based on existing terms; as an example of the latter, we can define a class <span class="nobreak">\(\exists\)<code>nearby</code>.<code>Airport</code></span> as the class of individuals that have some airport nearby. Noting that the symbol \(\top\) is used in DLs to denote the class of all individuals, we can then add a class axiom <span class="nobreak">\(\exists\)<code>flight</code>.\(\top \sqsubseteq \exists\)<code>nearby</code>.<code>Airport</code></span> to state that individuals with an outgoing flight must have some airport nearby. Noting that the symbol \(\sqcup\) can be used in DL to define that a class is the union of other classes, we can further define that <code>Airport</code>&nbsp;\(\sqsubseteq\)&nbsp;<code>DomesticAirport</code> \(\sqcup\) <code>InternationalAirport</code>, i.e., that an airport is either a domestic airport or an international airport (or both).</p>
		<p>The similarities between these DL features and the OWL features previously outlined in Tables&nbsp;<? echo ref("tab:ontEqIneq"). "–" .ref("tab:ontClass"); ?> are not coincidental: the OWL standard was heavily influenced by DLs, where, for example, the OWL 2 DL language is a fragment of OWL restricted so that entailment becomes decidable. As an example of a restriction, with <span class="nobreak"><code>DomesticAirport</code>&nbsp;\(\sqsubseteq ~=1\)&nbsp;<code>destination</code> \(\circ\) <code>country</code>.\(\top\)</span>, we can define in DL syntax that domestic airports have flights destined to precisely one country (where <span class="nobreak"><code>p</code>&nbsp;\(\circ\)&nbsp;<code>q</code></span> denotes a chain of properties). However, counting chains is often disallowed in DLs to ensure decidability.</p>
		<p>Expressive DLs support complex entailments involving existentials, universals, counting, etc. A common strategy for deciding such entailments is to reduce entailment to <em>satisfiability</em>, which decides if an ontology is consistent or not&nbsp;<? echo $references->cite("HorrocksP04"); ?>.<? echo footnote("\\(G\\) entails \\(G'\\) if and only if \\(G \\cup \\text{not}(G')\\) is not satisfiable."); ?> Thereafter methods such as <em>tableau</em> can be used to check satisfiability, cautiously constructing models by completing them along similar lines to the materialisation strategy previously described, but additionally branching models in the case of disjunction, introducing new elements to represent existentials, etc. If any model is successfully “completed”, the process concludes that the original definitions are satisfiable (see, e.g.,&nbsp;<? echo $references->cite("MotikSH09"); ?>). Due to their prohibitive computational complexity&nbsp;<? echo $references->cite("key:owl2profiles"); ?> – where for example, disjunction may lead to an exponential number of branching possibilities – such reasoning strategies are not typically applied in the case of large-scale data, though they may be useful when modelling complex domains.</p>

		<div class="formal">
			<p>Table&nbsp;<? echo ref("tab:dlsem"); ?> provides definitions for all of the constructs typically found in Description Logics. The syntax column denotes how the construct is expressed in DL. A DL knowledge base then consists of an A-Box, a T-Box, and an R-Box.</p>

			<dl class="definition" id="def-dl-knowledg-base">
				<dt>DL knowledge base</dt>
				<dd><em>DL knowledge base</em> \(\mathsf{K}\) is defined as a tuple \((\mathsf{A},\mathsf{T},\mathsf{R})\), where \(\mathsf{A}\) is the <em>A-Box</em>: a set of assertional axioms; \(\mathsf{T}\) is the <em>T-Box</em>: a set of class (aka concept/terminological) axioms; and \(\mathsf{R}\) is the <em>R-Box</em>: a set of relation (aka property/role) axioms.</dd>
			</dl>

			<p>The semantics column defines the meaning of axioms using <em>interpretations</em>. These interpretations are typically defined in a slightly different way to those previously defined for graphs, though the idea is roughly the same.</p>

			<dl class="definition" id="def-dl-interpretation">
				<dt>DL interpretation</dt>
				<dd>A <em>DL interpretation</em> \(I\) is defined as a pair \((\inpdom,\inp{\cdot})\), where \(\inpdom\) is the <em>interpretation domain</em>, and \(\inp{\cdot}\) is the <em>interpretation function</em>. The interpretation domain is a set of individuals. The interpretation function accepts a definition of either an individual \(a\), a class \(C\), or a relation \(R\), mapping them, respectively, to an element of the domain (\(\inp{a} \in \inpdom\)), a subset of the domain (\(\inp{C} \subseteq \inpdom\)), or a set of pairs from the domain (\(\inp{R} \subseteq \inpdom \times \inpdom\)).</dd>
			</dl>

			<p>An interpretation \(I\) <em>satisfies</em> a knowledge-base \(\mathsf{K}\) if and only if, for all of the syntactic axioms in \(\mathsf{K}\), the corresponding semantic conditions in Table&nbsp;<? echo ref("tab:dlsem"); ?> hold for \(I\). In this case, we call \(I\) a <em>model</em> of \(\mathsf{K}\).</p>
			<p>As an example, for \(\mathsf{K} \coloneqq (\mathsf{A},\mathsf{T},\mathsf{R})\), let:</p>
			<ul>
				<li>\(\mathsf{A} \coloneqq \{ \)<code>City(Arica)</code>, <code>City(Santiago)</code>, <code>flight(Arica,Santiago)</code>\(\}\);</li>
				<li>\(\mathsf{T} \coloneqq \{\)<code>City</code> \(\sqsubseteq\) <code>Place</code>, \(\exists\)<code>flight</code>\(.\top \sqsubseteq \exists\)<code>nearby</code>.<code>Airport</code>\(\} \);</li>
				<li>\(\mathsf{R} \coloneqq \{\)<code>flight</code> \(\sqsubseteq\) <code>connectsTo</code>\(\} \).</li>
			</ul>
			<p>For \(I = (\inpdom,\inp{\cdot})\), let:</p>
			<ul>
				<li>\(\inpdom \coloneqq \{ ⚓,\,🏔,\,🛪 \}\);</li>
				<li><code>Arica</code><sup>\(I\)</sup> \(\coloneqq\,⚓\), <code>Santiago</code><sup>\(I\)</sup> \(\coloneqq\,🏔\), <code>AricaAirport</code><sup>\(I\)</sup> \(\coloneqq\,🛪\);</li>
				<li><code>City</code><sup>\(I\)</sup> \(\coloneqq \{ ⚓,\,🏔 \}\), <code>Airport</code><sup>\(I\)</sup> \(\coloneqq \{ 🛪 \}\);</li>
				<li><code>flight</code><sup>\(I\)</sup> \(\coloneqq \{ (⚓,\,🏔) \}\), <code>connectsTo</code><sup>\(I\)</sup> \(\coloneqq \{ (⚓,\,🏔) \}\), <code>sells</code><sup>\(I\)</sup> \(\coloneqq \{ (🛪,\,☕) \}\).</li>
			</ul>
			<p>The interpretation \(I\) is not a model of \(\mathsf{K}\) since it does not have that \(⚓\) is <code>nearby</code> some <code>Airport</code>, nor that \(⚓\) and \(🏔\) are in the class <code>Place</code>. However, if we <em>extend</em> \(I\) with the following:</p>
			<ul>
				<li><code>Place</code><sup>\(I\)</sup> \(\coloneqq \{ ⚓,\,🏔 \}\);</li>
				<li><code>nearby</code> \(\coloneqq \{ (⚓,\,🛪) \}\).</li>
			</ul>
			<p>Now \(I\) is a model of \(\mathsf{K}\). Note that although \(\mathsf{K}\) does not imply that <code>sells(Arica,coffee)</code> while \(I\) indicates that \(🛪\) <code>sells</code> \(☕\), \(I\) is still a model of \(\mathsf{K}\) since \(\mathsf{K}\) is not assumed to be a complete description of the world, as per the Open World Assumption.</p>
			<p>Finally, the notion of a model gives rise to the key notion of entailment.</p>

			<dl class="definition" id="def-entailment">
				<dt>Entailment</dt>
				<dd>Given two DL knowledge bases \(\mathsf{K}_1\) and \(\mathsf{K}_2\), we define that \(\mathsf{K}_1\) entails \(\mathsf{K}_2\), denoted \(\mathsf{K}_1 \models \mathsf{K}_2\), if and only if any model of \(\mathsf{K}_2\) is a model of \(\mathsf{K}_1\).</dd>
			</dl>

			<p>The entailment relation tells us which knowledge bases hold as a logical consequence of which others: if all models of \(\mathsf{K}_2\) are also models of \(\mathsf{K}_1\) then, intuitively speaking, \(\mathsf{K}_2\) says nothing new over \(\mathsf{K}_1.\) For example, let \(\mathsf{K}_1\) denote the knowledge base \(\mathsf{K}\) from the previous example, and define a second knowledge base with one assertion: \(\mathsf{K}_2 \coloneqq ( \{ \)<code>connectsTo</code>\((\)<code>Arica</code>, <code>Santiago</code>\() \}, \{\}, \{\} )\). Though \(\mathsf{K}_1\) does not assert this axiom, it does entail \(\mathsf{K}_2\): to be a model of \(\mathsf{K}_2\), an interpretation must have that \((\)<code>Arica</code><sup>\(I\)</sup>, <code>Santiago</code>\() \in\) <code>connectsTo</code><sup>\(I\)</sup>, but this must also be the case for any interpretation that satisfies \(\mathsf{K}_1\) since it must have that \((\)<code>Arica</code><sup>\(I\)</sup>, <code>Santiago</code><sup>\(I\)</sup>\() \in \)<code>flight</code> and <code>flight</code> \(\subseteq\) <code>connectsTo</code><sup>\(I\)</sup>.</p>
			<p>Unfortunately, the problem of deciding entailment for knowledge bases expressed in the DL composed of the unrestricted use of all of the axioms of Table&nbsp;<? echo ref("tab:dlsem"); ?> combined is undecidable. We could, for example, reduce instances of the Halting Problem to such entailment. Hence DLs in practice restrict use of the features listed in Table&nbsp;<? echo ref("tab:dlsem"); ?>. Different DLs then apply different restrictions, implying different trade-offs for expressivity and the complexity of the entailment problem. Most DLs are founded on one of the following base DLs (we use indentation to denote derivation):</p>
			<ul>
				<li>[\(\mathcal{ALC}\)] (\(\mathcal{A}\)ttributive \(\mathcal{L}\)anguage with \(\mathcal{C}\)omplement}&nbsp;<? echo $references->cite("Schmidt-SchaussS91"); ?>), supports atomic classes, the top and bottom classes, class intersection, class union, class negation, universal restrictions and existential restrictions. Relation and class assertions are also supported.<ul>
					<li>[\(\mathcal{S}\)] extends \(\mathcal{ALC}\) with transitive closure.</li>
				</ul></li>
			</ul>
			<p>These base languages can be extended as follows:</p>
			<ul>
				<li>[\(\mathcal{H}\)] adds relation inclusion.<ul>
					<li>[\(\mathcal{R}\)] adds (limited) complex relation inclusion, as well as relation reflexivity, relation irreflexivity, relation disjointness and the universal relation.</li>
				</ul></li>
				<li>[\(\mathcal{O}\)] adds (limited) nomimals.</li>
				<li>[\(\mathcal{I}\)] adds inverse relations.</li>
				<li>[\(\mathcal{F}\)] adds (limited) functional properties.<ul>
					<li>[\(\mathcal{N}\)] adds (limited) number restrictions (subsuming \(\mathcal{F}\) given \(\top\)).<ul>
						<li>[\(\mathcal{Q}\)] adds (limited) qualified number restrictions (subsuming \(\mathcal{N}\) given \(\top\)).</li>
					</ul></li>
				</ul></li>
			</ul>
			<p>We use “(limited)” to indicate that such features are often only allowed under certain restrictions to ensure decidability; for example, complex relations (chains) typically cannot be combined with cardinality restrictions. DLs are then typically named per the following scheme, where \([a|b]\) denotes an alternative between \(a\) and \(b\) and \([c][d]\) denotes a concatenation \(cd\):</p>
			<p>\[ [\mathcal{ALC}|\mathcal{S}][\mathcal{H}|\mathcal{R}][\mathcal{O}][\mathcal{I}][\mathcal{F}|\mathcal{N}|\mathcal{Q}] \]</p>
			<p>Examples include \(\mathcal{ALCO}\), \(\mathcal{ALCHI}\), \(\mathcal{SHIF}\), \(\mathcal{SROIQ}\), etc. These languages often apply additional restrictions on class and property axioms to ensure decidability, which we do not discuss here. For further details on Description Logics, we refer to the recent book by <? echo $references->citet("BaaderHLS17"); ?>.</p>

			<p>As mentioned in the body of the survey, DLs have been very influential in the definition of OWL, where the OWL 2 DL fragment (roughly) corresponds to the DL \(\mathcal{SROIQ}\). For example, the axiom <? echo gedge("venue","domain","Event"); ?> in OWL can be translated to \(\exists\)<code>venue</code>\(.\top \sqsubseteq\) <code>Event</code>, meaning that the class of individuals with some value for <code>venue</code> (in any class) is a sub-class of the class <code>Event</code>. We leave other translations from the OWL axioms of Tables&nbsp;<? echo ref("tab:ontEqIneq"); ?>–<? echo ref("tab:ontClass"); ?> to DL as an exercise.<? echo footnote("Though not previously mentioned, OWL defines classes <code>Thing</code> and <code>Nothing</code> that corresponds to \\(\\top\\) and \\(\\bot\\), respectively."); ?> Note, however, that axioms like <? echo gedge("sub-taxon of","subp. of","subc. of"); ?> – which given a graph such as <? echo gedge("Fred","type","Homo sapiens") . esource(); ?><span class="edge">sub-taxon of</span><? echo etipr(); ?><span class="gnode">Hominini</span> entails the edge <? echo gedge("Fred","type","Hominini"); ?> – cannot be expressed in DL: “<code>subTaxonOf</code> \(\sqsubseteq\ \sqsubseteq\)” is not syntactically valid. Hence only a subset of graphs can be translated into well-formed DL ontologies; we refer to the OWL standard for details&nbsp;<? echo $references->cite("OWL2"); ?>.</p>
		</div>

		<div class="formal">
			<table id="tab-dlsem">
				<caption>Description Logic semantics</caption>
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
						<td>for all \(x \in \inpdom : (x,x) \in \inp{R}\)</td>
					</tr>
					<tr>
						<td>Irreflexive Relations</td>
						<td>\(\textsf{Irref}(R)\)</td>
						<td>for all \(x \in \inpdom : (x,x) \not\in \inp{R}\)</td>
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
						<td>\(\inp{a}\) (an element of \(\inpdom\))</td>
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
