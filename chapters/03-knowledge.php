	<section id="chap-knowledge" class="chapter">
		<h2>Schema, Identity, Context</h2>
		<p>In this chapter we describe extensions of the data graph – relating to schema, identity and context – that provide additional structures for accumulating knowledge. Henceforth, we refer to a <em>data graph</em> as a collection of data represented as nodes and edges using one of the models discussed in Chapter&nbsp;<?php echo ref("chap:graph"); ?>. We refer to a <em>knowledge graph</em> as a data graph potentially enhanced with representations of schema, identity, context, ontologies and/or rules. These additional representations may be embedded in the data graph, or layered above. Representations for schema, identity and context are discussed now, while ontologies and rules will be discussed in Chapter&nbsp;<?php echo ref("chap:deductive"); ?>.</p>

		<section id="sec-schema" class="section">
		<h3>Schema</h3>
		<p>One of the benefits of modelling data as graphs – versus, for example, the relational model – is the option to forgo or postpone the definition of a schema. However, when modelling data as graphs, schemata <em>can</em> be used to prescribe a high-level structure and/or semantics that the graph follows or should follow. We discuss three types of graph schemata: <em>semantic</em>, <em>validating</em>, and <em>emergent</em>.</p>

		<h4 id="sec-semSchema" class="subsection">Semantic schema</h4>
		<p>A semantic schema allows for defining the meaning of high-level terms (aka <em>vocabulary</em> or <em>terminology</em>) used in the graph, which facilitates reasoning over graphs using those terms. Looking at Figure&nbsp;<?php echo ref("fig:delg"); ?>, for example, we may notice some natural groupings of nodes based on the types of entities to which they refer. We may thus decide to define <em>classes</em>, such as <code>Event</code>, <code>City</code>, etc., to denote these groupings. In fact, Figure&nbsp;<?php echo ref("fig:delg"); ?> already illustrates three low-level classes – <code>Open Market</code>, <code>Food Market</code>, <code>Drinks Festival</code> – grouping similar entities with an edge labelled <span class="gelab">type</span>. We may subsequently wish to capture some relations between some of these classes. In Figure&nbsp;<?php echo ref("fig:classhier"); ?>, we present a class hierarchy for events where children are defined to be <em>sub-classes</em> of their parents such that if we find an edge <?php echo gedge("EID15","type","Food&nbsp;Festival"); ?> in our graph, we may also <em>infer</em> that <?php echo gedge("EID15","type","Festival"); ?> and <?php echo gedge("EID15","type","Event"); ?> hold in the graph.</p>

		<figure id="fig-classhier">
			<img src="images/fig-classhier.svg" alt="Example class hierarchy for Event"/>
			<figcaption>Example class hierarchy for <code>Event</code> <a class="git" title="Consult the code for this example on Github" href="https://github.com/Knowledge-Graphs-Book/examples/blob/main/Chapter_3_Schema_Identity_Context/3_1_1_Semantic_schema/figure_3_1.ttl"></a></figcaption>
		</figure>

		<p>Aside from classes, we may also wish to define the semantics of edge labels, aka <em>properties</em>. Returning to Figure&nbsp;<?php echo ref("fig:delg"); ?>, we may consider that the properties <span class="gelab">city</span> and <span class="gelab">venue</span> are <em>sub-properties</em> of a more general property <span class="gelab">location</span>, such that given an edge <?php echo gedge("Santa&nbsp;Lucía","city","Santiago"); ?>, for example, we may also infer that <?php echo gedge("Santa&nbsp;Lucía","location","Santiago"); ?> must hold as an edge in the graph. We may also consider, for example, that <span class="gelab">bus</span> and <span class="gelab">flight</span> are both sub-properties of a more general property <span class="gelab">connects&nbsp;to</span>. Along these lines, properties may also form a hierarchy similar to what we saw for classes. We may further define the <em>domain</em> of properties, indicating the class(es) of entities for nodes from which edges with that property extend; for example, we may define that the domain of <span class="gelab">connects&nbsp;to</span> is a class <code>Place</code>, such that given the previous sub-property relations, we infer <?php echo gedge("Arica","type","Place"); ?>. Conversely, we may define the <em>range</em> of properties, indicating the class(es) of entities for nodes to which edges with that property extend; for example, we may define that the range of <span class="gelab">city</span> is a class <code>City</code>, inferring that <?php echo gedge("Arica","type","City"); ?>.</p>
		<p>A prominent standard for defining a semantic schema for (RDF) graphs is the <em>RDF Schema</em> (<em>RDFS</em>) standard&nbsp;<?php echo $references->cite("RDFS"); ?>, which allows for defining sub-classes, sub-properties, domains, and ranges amongst the classes and properties used in an RDF graph, where such definitions can be serialised as a graph. We illustrate the semantics of these features in Table&nbsp;<?php echo ref("tab-semSchema"); ?> and provide a concrete example of definitions in Figure&nbsp;<?php echo ref("fig:sg"); ?> for a sample of terms used in the running example. These definitions can then be embedded into a data graph. More generally, the semantics of terms used in a graph can be defined in much more depth than seen here, as is supported by the <em>Web Ontology Language</em> (<em>OWL</em>) standard&nbsp;<?php echo $references->cite("OWL2"); ?> for RDF graphs. We will return to such semantics later in Chapter&nbsp;<?php echo ref("chap:deductive"); ?>.</p>

		<table class="normalTable" id="tab-semSchema">
			<caption>Definitions for sub-class, sub-property, domain and range</caption>
			<thead>
				<tr>
					<th>Feature</th>
					<th>Definition</th>
					<th>Condition</th>
					<th>Example</th>
				</tr>
			</thead>
			<tbody>
				<tr>
					<td>Sub-class</td>
					<td><?php echo gedge("\\(c\\)","subc.&nbsp;of","\\(d\\)"); ?></td>
					<td><?php echo gedge("\\(x\\)","type","\\(c\\)"); ?> implies <?php echo gedge("\\(x\\)","type","\\(d\\)"); ?></td>
					<td><?php echo gedge("City","subc.&nbsp;of","Place"); ?></td>
				</tr>
				<tr>
					<td>Sub-property</td>
					<td><?php echo gedge("\\(p\\)","subp.&nbsp;of","\\(q\\)"); ?></td>
					<td><?php echo gedge("\\(x\\)","\\(p\\)","\\(y\\)"); ?> implies <?php echo gedge("\\(x\\)","\\(q\\)","\\(y\\)"); ?></td>
					<td><?php echo gedge("venue","subp.&nbsp;of","location"); ?></td>
				</tr>
				<tr>
					<td>Domain</td>
					<td><?php echo gedge("\\(p\\)","domain","\\(c\\)"); ?></td>
					<td><?php echo gedge("\\(x\\)","\\(p\\)","\\(y\\)"); ?> implies <?php echo gedge("\\(x\\)","type","\\(c\\)"); ?></td>
					<td><?php echo gedge("venue","domain","Event"); ?></td>
				</tr>
				<tr>
					<td>Range</td>
					<td><?php echo gedge("\\(p\\)","range","\\(c\\)"); ?></td>
					<td><?php echo gedge("\\(x\\)","\\(p\\)","\\(y\\)"); ?> implies <?php echo gedge("\\(y\\)","type","\\(c\\)"); ?></td>
					<td><?php echo gedge("venue","range","Venue"); ?></td>
				</tr>
			</tbody>
		</table>
		<figure id="fig-sg">
			<img src="images/fig-sg.svg" alt="Example schema graph describing sub-classes, sub-properties, domains, and ranges"/>
			<figcaption>Example schema with sub-classes, sub-properties, domains, and ranges <a class="git" title="Consult the code for this example on Github" href="https://github.com/Knowledge-Graphs-Book/examples/blob/main/Chapter_3_Schema_Identity_Context/3_1_1_Semantic_schema/figure_3_2.ttl"></a></figcaption>
		</figure>

		<p>Semantic schemata are typically defined for incomplete graph data, where the absence of an edge between two nodes, such as <?php echo gedge("Viña&nbsp;del&nbsp;Mar","flight","Arica"); ?>, does not mean that the relation does not hold in the real world. Therefore, from the graph of Figure&nbsp;<?php echo ref("fig:delg"); ?>, we cannot assume that there is no flight between Viña del Mar and Arica. In contrast, if the <em>Closed World Assumption</em> (<em>CWA</em>) were adopted – as is the case in many classical database systems – it would be assumed that the data graph is a complete description of the world, thus allowing to assert with certainty that no flight exists between the two cities. Systems that do not adopt the CWA are said to adopt the <em>Open World Assumption</em> (<em>OWA</em>). Considering our running example, it would be unreasonable to assume that the tourism organisation has complete knowledge of everything describable in its knowledge graph, and hence adopting the OWA appears more appropriate. However, it can be inconvenient if a system is unable to definitely answer “<em>yes</em>” or “<em>no</em>” to questions such as “<em>is there a flight between Arica and Viña del Mar?</em>”, especially when the organisation is certain that it has complete knowledge of the flights. A compromise between OWA and CWA is the <em>Local Closed World Assumption</em> (<em>LCWA</em>), where portions of the data graph are assumed to be complete.</p>

		<h4 id="sssec-validating-schema" class="subsection">Validating schema</h4>
		<p>When graphs are used to represent diverse, incomplete data at large scale, the OWA is the most appropriate choice for a <em>default</em> semantics. But in some scenarios, we may wish to guarantee that our data graph – or specific parts thereof – are in some sense “complete”. Returning to Figure&nbsp;<?php echo ref("fig:delg"); ?>, for example, we may wish to ensure that all events have at least a name, a venue, a start date, and an end date, such that applications using the data – e.g., one that sends event notifications to users – can ensure that they have the minimal information required. Furthermore, we may wish to ensure that the city of an event is <em>stated to be</em> a city (rather than <em>inferring</em> that it is a city). We can define such constraints in a validating schema and validate the data graph with respect to the resulting schema, listing constraint violations (if any). Thus while semantic schemata allow for inferring new graph data, validating schemata allow for validating a given data graph with respect to some constraints.</p>
		<p>A standard way to define a validating schema for graphs is using <em>shapes</em>&nbsp;<?php echo $references->cite("SHACLSpec,Prudhommeaux2014,Labra2017"); ?>. A shape <em>targets</em> a set of nodes in a data graph and specifies <em>constraints</em> on those nodes. The shape’s target can be defined in many ways, such as targeting all instances of a class, the domain or range of a property, the result of a query, nodes connected to the target of another shape by a given property, etc. Constraints can then be defined on the targeted nodes, such as to restrict the number or types of values taken on a given property, the shapes that such values must satisfy, etc.</p>
		<p>A <em>shapes graph</em> is formed from a set of interrelated shapes. Shapes graphs can be depicted as UML-like class diagrams, where Figure&nbsp;<?php echo ref("fig:shapeExample"); ?> illustrates an example of a shapes graph based on Figure&nbsp;<?php echo ref("fig:delg"); ?>, defining constraints on four interrelated shapes. Each shape – denoted with a box like <span class="shap">Place</span>, <span class="shap">Event</span>, etc. – is associated with a set of constraints. Nodes conform to a shape if and only if they satisfy all constraints defined on the shape. Inside each shape box are placed constraints on the number (e.g., <code>[1..*]</code> denotes one-to-many, <code>[1..1]</code> denotes precisely one, etc.) and types (e.g., <code>string</code>, <code>dateTime</code>, etc.) of nodes that conforming nodes can relate to with a property (e.g., <span class="gelab">name</span>, <span class="gelab">start</span>, etc.). Another option is to place constraints on the number of nodes conforming to a particular shape that the conforming node can relate to with a property (thus generating edges between shapes); for example, <?php echo sedge("Event","venue","1..*","Venue"); ?> denotes that conforming nodes for <span class="shap">Event</span> must relate to at least one node with the property <span class="gelab">venue</span> that conforms to the <span class="shap">Venue</span> shape. Shapes can inherit the constraints of parent shapes – with inheritance denoted with an \(\triangle\) connector – as in the case of <span class="shap">City</span> and <span class="shap">Venue</span>, whose conforming nodes must also conform to the <span class="shap">Place</span> shape.</p>

		<figure id="fig-shapeExample">
			<img src="images/fig-shapeExample.svg" alt="Example shapes graph depicted as a UML-like diagram"/>
			<figcaption>Example shapes graph depicted as a UML-like diagram <a class="git" title="Consult the code for this example on Github" href="https://github.com/Knowledge-Graphs-Book/examples/blob/main/Chapter_3_Schema_Identity_Context/3_1_2_Validating_schema/"></a></figcaption>
		</figure>

		<p>Given a shape and a targeted node, it is possible to check if the node conforms to that shape or not, which may require checking conformance of other nodes; for example, the node <span class="gnode">EID15</span> conforms to the <span class="shap">Event</span> shape not only based on its local properties, but also based on conformance of <span class="gnode">Santa&nbsp;Lucía</span> to <span class="shap">Venue</span> and <span class="gnode">Santiago</span> to <span class="shap">City</span>. Conformance dependencies may also be recursive, where the conformance of <span class="gnode">Santiago</span> to <span class="shap">City</span> requires that it conforms to <span class="shap">Place</span>, which requires that <span class="gnode">Viña&nbsp;del&nbsp;Mar</span> and <span class="gnode">Arica</span> conform to <span class="shap">Place</span>, and so on. Conversely, <span class="gnode">EID16</span> does not conform to <span class="gnode">Event</span>, as it does not have the <span class="gelab">start</span> and <span class="gelab">end</span> properties required by the example shapes graph.</p>
		<p>When declaring shapes, the data modeller may not know in advance the entire set of properties that some nodes can have (now or in the future). An <em>open shape</em> allows the node to have additional properties not specified by the shape, while a <em>closed shape</em> does not. For example, if we add the edge <?php echo gedge("Santiago","founder","Pedro&nbsp;de&nbsp;Valdivia"); ?> to the graph represented in Figure&nbsp;<?php echo ref("fig:delg"); ?>, then <span class="gnode">Santiago</span> only conforms to the <span class="shap">City</span> shape if the shape is defined as open (since the shape does not mention <span class="gelab">founder</span>).</p>
		<p>Practical languages for shapes often support additional Boolean features, such as conjunction (<em class="sc">and</em>), disjunction (<em class="sc">or</em>), and negation (<em class="sc">not</em>) of shapes; for example, we may say that all the values of <span class="gelab">venue</span> should conform to the shape <span class="shap"><span class="sc">Venue</span> <em>and</em> (<em>not</em> <span class="sc">City</span>)</span>, making explicit that venues in the data graph should not be directly given as cities. However, shapes languages that freely combine recursion and negation may lead to semantic problems, depending on how their semantics are defined. To illustrate, consider the following case inspired by the barber paradox&nbsp;<?php echo $references->cite("Labra2017"); ?>, involving a shape <span class="shap">Barber</span> whose conforming nodes <span class="gelab">shave</span> at least one node conforming to <span style="white-space:nowrap;"><span class="shap"><span class="sc">Person</span> <em>and</em> (<em>not</em> <span class="sc">Barber</span>)</span>.</span> Now, given (only) <?php echo gedge("Bob","shave","Bob"); ?> with <span class="gnode">Bob</span> conforming to <span class="shap">Person</span>, does <span class="gnode">Bob</span> conform to <span class="shap">Barber</span>? If <em>yes</em> – if <span class="gnode">Bob</span> conforms to <span class="shap">Barber</span> – then <span class="gnode">Bob</span> violates the constraint by not shaving at least one node conforming to <span class="shap"><span class="sc">Person</span> <em>and</em> (<em>not</em> <span class="sc">Barber</span>)</span>. If <em>no</em> – if <span class="gnode">Bob</span> does not conform to <span class="shap">Barber</span> – then <span class="gnode">Bob</span> satisfies the <span class="shap">Barber</span> constraint by shaving such a node. Semantics to avoid such paradoxical situations have been proposed based on stratification&nbsp;<?php echo $references->cite("Boneva2017"); ?>, partial assignments&nbsp;<?php echo $references->cite("Corman2018b"); ?>, and stable models&nbsp;<?php echo $references->cite("Gelfond88"); ?>.</p>
		<p>Although validating schemata and semantic schemata serve different purposes, they can complement each other. In particular, a validating schema can take into consideration a semantic schema, such that, for example, validation is applied on the data graph including inferences. Taking the class hierarchy of Figure&nbsp;<?php echo ref("fig:classhier"); ?> and the shapes graph of Figure&nbsp;<?php echo ref("fig:shapeExample"); ?>, for example, we may define the target of the <span class="shap">Event</span> shape as the nodes that are of type <code>Event</code> (the class). If we first apply inferencing with respect to the class hierarchy of the semantic schema, the <span class="shap">Event</span> shape would now target <span class="gnode">EID15</span> and <span class="gnode">EID16</span>. The presence of a semantic schema may, however, require adapting the validating schema. Taking into account, for example, the aforementioned class hierarchy would require defining a relaxed cardinality on the <span class="gelab">type</span> property. Open shapes may also be preferred in such cases rather than enumerating constraints on all possible properties that may be inferred on a node.</p>
		<p>Two shapes languages have recently emerged for RDF graphs: <em>Shape Expressions</em> (<em>ShEx</em>), published as a W3C Community Group Report&nbsp;<?php echo $references->cite("Prudhommeaux2014"); ?>; and <em>SHACL</em> (<em>Shapes Constraint Language</em>), published as a W3C Recommendation&nbsp;<?php echo $references->cite("SHACLSpec"); ?>. These languages support the discussed features (and more) and have been adopted for validating graphs in a number of domains relating to healthcare&nbsp;<?php echo $references->cite("ThorntonSSGMPW19"); ?>, scientific literature&nbsp;<?php echo $references->cite("HammondPT17"); ?>, spatial data&nbsp;<?php echo $references->cite("Car2019"); ?>, amongst others. More details about ShEx and SHACL can be found in the book by <?php echo $references->citet("Labra2017"); ?>. A recently proposed language that can be used as a common basis for both ShEx and SHACL reveals their similarities and differences&nbsp;<?php echo $references->cite("Labra-Gayo2019"); ?>. A similar notion of schema has been proposed by <?php echo $references->citet("Angles18"); ?> for property graphs.</p>

		<div class="formal">
			<p>We formally define shapes following the conventions of&nbsp;<?php echo $references->citet("Labra-Gayo2019"); ?>.</p>

			<dl class="definition" id="def-shape">
				<dt>Shape</dt>
				<dd>A <em>shape</em> \(\phi\) is defined as:
				<table>
					<tr>
						<td>\(\phi\)</td>
						<td>::=</td>
						<td>\(\top\)</td>
						<td>true</td>
					</tr>
					<tr>
						<td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
						<td> \( | \) </td>
						<td>\(\datatype{N}\)</td>
						<td>node belongs to the set of nodes \(N\)</td>
					</tr>
					<tr>
						<td></td>
						<td> \( | \) </td>
						<td>\(\Psi_{\mathrm{cond}}\)</td>
						<td>node satisfies the Boolean condition \(\mathrm{cond}\)</td>
					</tr>
					<tr>
						<td></td>
						<td> \( | \) </td>
						<td>\(\phi_1 \wedge \phi_2\)</td>
						<td>conjunction of shape \(\phi_1\) and shape \(\phi_2\)</td>
					</tr>
					<tr>
						<td></td>
						<td> \( | \) </td>
						<td>\(\lnot \phi \)</td>
						<td>negation of shape \(\phi\)</td>
					</tr>
					<tr>
						<td></td>
						<td> \( | \) </td>
						<td>\(@s\)</td>
						<td>reference to shape with label \(s\)</td>
					</tr>
					<tr>
						<td></td>
						<td> \( | \) </td>
						<td>\(\qualified{p}{\phi}{min}{max}\)&nbsp;</td>
						<td>between \(min\) and \(max\) outward edges (inclusive) with label \(p\)<br/> to nodes satisfying shape \(\phi\)</td>
					</tr>
				</table>
				where \(min \in \mathbb{N}_{(0)}\), \(max \in \mathbb{N}_{(0)} \cup \{ * \}\), with “\(*\)” indicating unbounded.</dd>
			</dl>

			<dl class="definition" id="def-shapes-schema">
				<dt>Shapes schema</dt>
				<dd>A <em>shapes schema</em> is defined as a tuple \(\Sigma = (\Phi,S,\lambda)\) where \(\Phi\) is a set of shapes, \(S\) is a set of shape labels, and \(\lambda : S \rightarrow \Phi\) is a total function from labels to shapes.</dd>
			</dl>

			<div class="example">
				<p>The shapes schema from Figure&nbsp;<?php echo ref("fig:shapeExample"); ?> can be expressed as:</p>
				<table>
					<tr>
						<td><span class="shap">Event</span></td>
						<td>\(\mapsto\)</td>
						<td>\(\qualifiedL{name}{\datatypeL{string}}{1}{*}\wedge\qualifiedL{start}{\datatypeL{dateTime}}{1}{1}\wedge\qualifiedL{end}{\datatypeL{dateTime}}{1}{1}\)</td>
					</tr>
					<tr>
						<td></td>
						<td></td>
						<td>\(\qquad\wedge\qualifiedL{type}{\top}{1}{*}\wedge\xrightarrow{venue}\)<span class="shap">Venue</span>\(\{1,*\}\)</td>
					</tr>
					<tr>
						<td><span class="shap">Venue</span></td>
						<td>\(\mapsto\)</td>
						<td><span class="shap">Place</span>\(\:\wedge\qualifiedL{indoor}{\datatypeL{boolean}}{0}{1}\wedge\xrightarrow{city}\)<span class="shap">City</span>\(\{0,1\}\)</td>
					</tr>
					<tr>
						<td><span class="shap">City</span></td>
						<td>\(\mapsto\)</td>
						<td><span class="shap">Place</span>\(\:\wedge\qualifiedL{population}{(\datatypeL{int}\wedge \Psi_{>5000})}{0}{1}\)</td>
					</tr>
					<tr>
						<td><span class="shap">Place</span></td>
						<td>\(\mapsto\)</td>
						<td>\(\qualifiedL{lat}{\datatypeL{float}}{0}{1}\wedge\qualifiedL{long}{\datatypeL{float}}{0}{1}\)</td>
					</tr>
					<tr>
						<td></td>
						<td></td>
						<td>\(\qquad\wedge\xrightarrow{flight}\)<span class="shap">Place</span>\(\{0,*\}\wedge\xrightarrow{bus}\)<span class="shap">Place</span>\(\{0,*\}\)</td>
					</tr>
				</table>
				<p>For example, <span class="shap">Event</span> is a shape label (an element of \(S\)) that maps to a shape (an element of \(\phi\)). This mapping is defined by \(\lambda\).</p>
			</div>

			<p>In a shapes schema, shapes may refer to other shapes, giving rise to a graph that is sometimes known as the <em>shapes graph</em>&nbsp;<?php echo $references->cite("SHACLSpec"); ?>. Figure&nbsp;<?php echo ref("fig:shapeExample"); ?> illustrates a shapes graph of this form.</p>
			<p>The semantics of a shape is defined in terms of the evaluation of that shape over each node of a given data graph. The semantics of a shapes schema, in turn, is the result of evaluating each shape of the schema over each node of a given data graph; the result of this evaluation is a <em>shapes map</em>.</p>

			<dl class="definition" id="def-shape-map">
				<dt>Shapes map</dt>
				<dd>Given a directed edge-labelled graph \(G = (V,E,L)\) and a shapes schema \(\Sigma = (\Phi,S,\lambda)\), a <em>shapes map</em> is a (partial) mapping \(\sigma: V \times S \rightarrow \{ 0, 1 \}\).</dd>
			</dl>

			<p>The shapes map \(\sigma\) is a way of labelling the nodes of \(G\) with the labels of shapes from \(S\). If \(\sigma(v,s) = 1\), then node \(v\) is labelled \(s\) (possibly amongst other labels); otherwise if \(\sigma(v,s) = 0\), then node \(v\) is not labelled \(s\). The precise semantics depends on  whether or not \(\sigma\) is a total or partial mapping: whether or not it is defined for every pair in \(V \times S\). Herein we present the semantics for the more straightforward case wherein \(\sigma\) is assumed to be a total shapes map.</p>

			<dl class="definition" id="def-shape-evaluation">
				<dt>Shape evaluation</dt>
				<dd>Given a shapes schema \(\Sigma \coloneqq (\Phi,S,\lambda)\), a directed edge-labelled graph \(G = (V,E,L)\), a node \(v \in V\) and a total shapes map \(\sigma\), the <em>shape evaluation function</em> \(\semantics{\phi}{G}{v}{\sigma} \in \{ 0 , 1 \}\) is defined as follows:
				<table>
					<tr>
						<td>\(\semantics{\top}{G}{v}{\sigma}\)</td>
						<td>\(=\)</td>
						<td>\(1\)</td>
					</tr>
					<tr>
						<td>\(\semantics{\datatype{N}}{G}{v}{\sigma}\)</td>
						<td>\(=\)</td>
						<td>\(1\) iff \(v \in N\)</td>
					</tr>
					<tr>
						<td>\(\semantics{\Psi_{\mathrm{cond}}}{G}{v}{\sigma}\)</td>
						<td>\(=\)</td>
						<td>\(1\) iff \(\mathrm{cond}(v)\) is true</td>
					</tr>
					<tr>
						<td>\(\semantics{\phi_1 \wedge \phi_2}{G}{v}{\sigma}\)</td>
						<td>\(=\)</td>
						<td>\(\min\{\semantics{\phi_1}{G}{v}{\sigma}, \semantics{\phi_2}{G}{v}{\sigma}\}\)</td>
					</tr>
					<tr>
						<td>\(\semantics{\lnot \phi}{G}{v}{\sigma}\)</td>
						<td>\(=\)</td>
						<td>\(1 - \semantics{\phi}{G}{v}{\sigma}\)</td>
					</tr>
					<tr>
						<td>\(\semantics{@s}{G}{v}{\sigma}\)</td>
						<td>\(=\)</td>
						<td>\(1\) iff \(\sigma(v,s) = 1\)</td>
					</tr>
					<tr>
						<td>\(\semantics{\qualified{p}{\phi}{min}{max}}{G}{v}{\sigma}\)</td>
						<td>\(=\)</td>
						<td>\(1\) iff \(min \leq \lvert \{ (v,p,u)\in E \mid \semantics{\phi}{G}{u}{\sigma}=1 \} \rvert \leq max\)</td>
					</tr>
				</table>
				If \(\semantics{\phi}{G}{v}{\sigma} = 1\), then \(v\) is said to <em>satisfy</em> \(\phi\) in \(G\) under \(\sigma\).</dd>
			</dl>

			<p>Typically for the purposes of validating a graph with respect to a shapes schema, a <em>target</em> is defined that requires certain nodes to satisfy certain shapes.</p>

			<dl class="definition" id="def-shape-target">
				<dt>Shapes target</dt>
				<dd>Given a directed edge-labelled graph \(G = (V,E,L)\) and a shapes schema \(\Sigma = (\Phi,S,\lambda)\), a <em>shapes target</em> \(T \subseteq V \times S\) is a set of pairs of nodes and shape labels from \(G\) and \(\Sigma\), respectively.</dd>
			</dl>

			<p>The nodes that a shape targets can be selected a manual selection, based on the type(s) of the nodes, based on the results of a graph query, etc.&nbsp;<?php echo $references->cite("Corman2018b,Labra-Gayo2019"); ?>.</p>
			<p>Lastly, we define the notion of a valid graph under a given shapes schema and target based on the existence of a shapes map satisfying certain conditions.</p>

			<dl class="definition" id="def-valid-graph">
				<dt>Valid graph</dt>
				<dd>Given a shapes schema \(\Sigma = (\Phi,S,\lambda)\), a directed edge-labelled graph \(G = (V,E,L)\), and a shapes target \(T\), we say that <em>\(G\) is valid under \(\Sigma\) and \(T\)</em> if and only if there exists a shapes map \(\sigma\) such that, for all \(s \in S\) and \(v \in V\) it holds that \(\sigma(v,s) = \semantics{\lambda(s)}{G}{v}{\sigma}\), and \((v,s) \in T\) implies \(\sigma(v,s) = 1\).</dd>
			</dl>

			<div class="example">
				<p>Taking the graph \(G\) from Figure&nbsp;<?php echo ref("fig:delg"); ?> and the shapes schema \(\Sigma\) from Figure&nbsp;<?php echo ref("fig:shapeExample"); ?>, first assume an empty shapes target \(T = \{\}\). If we consider a shapes map where (e.g.) \(\sigma(\)<span class="gnode">EID15</span>, <span class="shap">Event</span>\() = 1\), \(\sigma(\)<span class="gnode">Santa Lucía</span>, <span class="shap">Venue</span>\() = 1\), \(\sigma(\)<span class="gnode">Santa Lucía</span>, <span class="shap">Place</span>\() = 1\), etc., but where \(\sigma(\)<span class="gnode">EID16</span>, <span class="shap">Event</span>\() = 0\) (as it does not have the required values for <span class="gelab">start</span> and <span class="gelab">end</span>), etc., then we see that \(G\) is valid under \(\Sigma\) and \(T\). However, if we were to define a shapes target \(T\) to ensure that the <span class="shap">Event</span> shape targets <span class="gnode">EID15</span> and <span class="gnode">EID16</span> – i.e., to define \(T\) such that \(\{ (\)<span class="gnode">EID15</span>, <span class="shap">Event</span>\(), (\)<span class="gnode">EID16</span>, <span class="shap">Event</span>\() \} \subseteq T\) – then the graph would no longer be valid under \(\Sigma\) and \(T\) since <span class="gnode">EID16</span> does not satisfy <span class="shap">Event</span>.</p>
			</div>

			<p>The semantics we present here assumes that each node in the graph either satisfies or does not satisfy each shape labelled by the schema. More complex semantics – for example, based on Kleene’s three-valued logic&nbsp;<?php echo $references->cite("Corman2018b,Labra-Gayo2019"); ?> – have been proposed that support partial shapes maps, where the satisfaction of some nodes for some shapes can be left as undefined. Shapes languages in practice may support other more advanced forms of constraints, such as counting on paths&nbsp;<?php echo $references->cite("SHACLSpec"); ?>. In terms of implementing validation with respect to shapes, work has been done on translating constraints into sets of graph queries, whose results are input to a SAT solver for recursive cases&nbsp;<?php echo $references->cite("CormanFRS19a"); ?>.</p>
		</div>
		
		<h4 id="ssec-emergentSchema" class="subsection">Emergent schema</h4>
		<p>Both semantic and validating schemata require a domain expert to explicitly specify definitions and constraints. However, a data graph will often exhibit latent structures that can be automatically extracted as an <em>emergent schema</em>&nbsp;<?php echo $references->cite("PhamPEB15"); ?> (aka <em>graph summary</em>&nbsp;<?php echo $references->cite("LiuSDK18,CebiricGKKMTZ19,SpahiuPPRM16a"); ?>).</p>
		<p>A framework often used for defining emergent schema is that of <em>quotient graphs</em>, which partition groups of nodes in the data graph according to some equivalence relation while preserving some structural properties of the graph. Taking Figure&nbsp;<?php echo ref("fig:delg"); ?>, we can intuitively distinguish different <em>types</em> of nodes based on their context, such as event nodes, which link to venue nodes, which in turn link to city nodes, and so forth. In order to describe the structure of the graph, we could consider six partitions of nodes: <em>event</em>, <em>name</em>, <em>venue</em>, <em>class</em>, <em>date-time</em>, <em>city</em>. In practice, these partitions may be computed based on the class or shape of the node. Merging the nodes of each partition into one node while preserving edges leads to the quotient graph shown in Figure&nbsp;<?php echo ref("fig:emergentSchema"); ?>: the nodes of this quotient graph are the partitions of nodes from the data graph and an edge <?php echo gedge("\\(X\\)","\\(y\\)","\\(Z\\)"); ?> is included in the quotient graph if and only if there exists \(x \in X\) and \(z \in Z\) such that <?php echo gedge("\\(x\\)","\\(y\\)","\\(z\\)"); ?> is in the original data graph.</p>

		<figure id="fig-emergentSchema">
			<img src="images/fig-emergentSchema.svg" alt="Example quotient graph simulating the data graph in Figure&nbsp;1"/>
			<figcaption>Example quotient graph simulating the data graph in Figure&nbsp;<?php echo ref("fig:delg"); ?> <a class="git" title="Consult the code for this example on Github" href="https://github.com/Knowledge-Graphs-Book/examples/blob/main/Chapter_3_Schema_Identity_Context/3_1_3_Emergent_schema/figure_3_4.ttl"></a></figcaption>
		</figure>

		<p>There are many ways in which quotient graphs may be defined, depending not only on how nodes are partitioned, but also how the edges are defined. Different quotient graphs may provide different guarantees with respect to the structure they preserve. Formally, we can say that every quotient graph <em>simulates</em> its input graph (based on the <em>simulation relation</em> of set membership between data nodes and quotient nodes), meaning that for all \(x \in X\) with \(x\) an input node and \(X\) a quotient node, if <?php echo gedge("\\(x\\)","\\(y\\)","\\(z\\)"); ?> is an edge in the data graph, then there must exist an edge <?php echo gedge("\\(X\\)","\\(y\\)","\\(Z\\)"); ?> in the quotient graph such that \(z \in Z\); for example, the quotient graph of Figure&nbsp;<?php echo ref("fig:emergentSchema"); ?> simulates the data graph of Figure&nbsp;<?php echo ref("fig:delg"); ?>. However, this quotient graph seems to suggest (for instance) that <span class="gnode">EID16</span> would have a start and end date in the data graph when this is not the case. A stronger notion of structural preservation is given by <em>bisimilarity</em>, which in this case would further require that if <?php echo gedge("\\(X\\)","\\(y\\)","\\(Z\\)"); ?> is an edge in the quotient graph, then for all \(x \in X\), there must exist a \(z \in Z\) such that <?php echo gedge("\\(x\\)","\\(y\\)","\\(z\\)"); ?> is in the data graph; this is not satisfied by <span class="gnode">EID16</span> in the quotient graph of Figure&nbsp;<?php echo ref("fig:emergentSchema"); ?>, which does not have an outgoing edge labelled <span class="gelab">start</span> or <span class="gelab">end</span> in the original data graph. Figure&nbsp;<?php echo ref("fig:emergentSchema2"); ?> illustrates a bisimilar version of the quotient graph, splitting the <em>event</em> partition into two nodes reflecting their different outgoing edges. An interesting property of bisimilarity is that it preserves forward-directed paths: given a path expression \(r\) without inverses and two bisimilar graphs, \(r\) will match a path in one graph if and only if it matches a corresponding path in the other bisimilar graph. One can verify, for example, that a path matches <?php echo gedge("\\(x\\)","city\\(\cdot\\)(flight|bus)*","\\(z\\)"); ?> in Figure&nbsp;<?php echo ref("fig:delg"); ?> if and only if there is a path matching <?php echo gedge("\\(X\\)","city\\(\cdot\\)(flight|bus)*","\\(Z\\)"); ?> in Figure&nbsp;<?php echo ref("fig:emergentSchema2"); ?> such that \(x \in X\) and \(z \in Z\).</p>

		<figure id="fig-emergentSchema2">
			<img src="images/fig-emergentSchema2.svg" alt="Example quotient graph bisimilar with the data graph in Figure&nbsp;1"/>
			<figcaption>Example quotient graph bisimilar with the data graph in Figure&nbsp;<?php echo ref("fig:delg"); ?> <a class="git" title="Consult the code for this example on Github" href="https://github.com/Knowledge-Graphs-Book/examples/blob/main/Chapter_3_Schema_Identity_Context/3_1_3_Emergent_schema/figure_3_5.ttl"></a></figcaption>
		</figure>

		<p>There are many ways in which quotient graphs may be defined, depending on the equivalence relation that partitions nodes. Furthermore, there are many ways in which other similar or bisimilar graphs can be defined, depending on the (bi)simulation relation that preserves the data graph’s structure&nbsp;<?php echo $references->cite("CebiricGKKMTZ19"); ?>. Such techniques aim to <em>summarise</em> the data graph into a higher-level topology. In order to reduce the memory overhead of the quotient graph, in practice, nodes may rather be labelled with the cardinality of the partition and/or a high-level label (e.g., <em>event</em>, <em>city</em>) for the partition rather than storing the labels of all nodes in the partition.</p>
		<p>Various other forms of emergent schema not directly based on a quotient graph framework have also been proposed; examples include emergent schemata based on relational tables&nbsp;<?php echo $references->cite("PhamPEB15"); ?>, and baseed on formal concept analysis&nbsp;<?php echo $references->cite("GonzalezH18"); ?>. Emergent schemata may be used to provide a human-understandable overview of the data graph, to aid with the definition of a semantic or validating schema, to optimise the indexing and querying of the graph, to guide the integration of data graphs, and so forth. We refer to the survey by <?php echo $references->citet("CebiricGKKMTZ19"); ?> dedicated to the topic for further details.</p>
		
		<div class="formal">
			<p>Emergent schemata are often based on the notion of a quotient graph.</p>

			<dl class="definition" id="def-qg">
				<dt>Quotient graph</dt>
				<dd>Given a directed edge-labelled graph \(G = (V,E,L)\), a graph \(\mathcal{G} = (\mathcal{V},\mathcal{E},L)\) is a <em>quotient graph</em> of \(G\) if and only if:
					<ul>
						<li>\(\mathcal{V}\) is a partition of \(V\) without the empty set, i.e., \(\mathcal{V} \subseteq (2^V - \emptyset)\), \(V = \bigcup_{U\in \mathcal{V}} U\), and for all \(U\in \mathcal{V}\), \(W\in \mathcal{V}\), it holds that \(U = W\) or \(U \cap W = \emptyset\); <em>and</em></li>
						<li>\(\mathcal{E} = \{ (U,l,W) \mid U \in \mathcal{V}, W \in \mathcal{V} \text{ and } \exists u \in U, \exists w \in W : (u,l,w) \in E \} \).</li>
					</ul>
				</dd>
			</dl>

			<p>A quotient graph can “merge” multiple nodes into one node, keeping the edges of its constituent nodes. For an input graph \(G = (V,E,L)\), there is an exponential number of possible quotient graphs based on partitions of the input nodes. On one extreme, the input graph is a quotient graph of itself (turning nodes like <span class="gnode">u</span> into singleton nodes like <span class="gnode">\(\{\)u\(\}\)</span>). On the other extreme, a single node <span class="gnode">\(V\)</span>, with all input nodes, and loops \((V,l,V)\) for each edge-label \(l\) used in the set of input edges \(E\), is also a quotient graph. Quotient graphs typically fall somewhere in between, where the partition \(\mathcal{V}\) of \(V\) is often defined in terms of an <em>equivalence relation</em> \(\sim\) on the set \(V\) such that \(\mathcal{V} \coloneqq {\sim}/V\); i.e., \(\mathcal{V}\) is defined as the <em>quotient set</em> of \(V\) with respect to \(\sim\); for example, we might define an equivalence relation on nodes such that \(u \sim v\) if and only if they have the same set of defined types, where \({\sim}/V\) is then a partition whose parts contain all nodes with the same types. Another way to induce a quotient graph is to define the partition in a way that preserves some of the topology (i.e., connectivity) of the input graph. One way to formally define this idea is through <em>simulation</em> and <em>bisimulation</em>.</p>

			<dl class="definition" id="def-sim">
				<dt>Simulation</dt>
				<dd>Given two directed edge-labelled graph \(G = (V,E,L)\) and \(G' = (V',E',L')\), let \(R \subseteq V \times V'\) be a relation between the nodes of \(G\) and \(G'\), respectively. We call \(R\) a <em>simulation</em> on \(G\) and \(G'\) if, for all \((v,v') \in R\), the following holds:
				<ul>
					<li>if \((v,p,w) \in E\) then there exists \(w'\) such that \((v',p,w') \in E'\) and \((w,w') \in R\).</li>
				</ul>
				If a simulation exists on \(G\) and \(G'\), we say that \(G'\) <em>simulates</em> \(G\), denoted \(G \rightsquigarrow G'\).</dd>
			</dl>

			<dl class="definition" id="def-bisim">
				<dt>Bisimulation</dt>
				<dd>If \(R\) is a simulation on \(G\) and \(G'\), we call it a <em>bisimulation</em> if, for all \((v,v') \in R\), the following condition holds:
				<ul>
					<li>if \((v'p,w') \in E'\) then there exists \(w\) such that \((v,p,w) \in E\) and \((w,w') \in R\).</li>
				</ul>
				If a bisimulation exists on \(G\) and \(G'\), we call them <em>bisimilar</em>, denoted \(G \approx G'\).</dd>
			</dl>

			<p>Bisimulation (\(\approx\)) is then an equivalence relation on graphs. By defining the (bi)simulation relation \(R\) in terms of set membership \(\in\), every quotient graph simulates its input graph, but does not necessarily bisimulate its input graph. This gives rise to the notion of <em>bisimilar quotient graphs</em>.</p>

			<div class="example">
				<p>Figures&nbsp;<?php echo ref("fig:emergentSchema"); ?> and&nbsp;<?php echo ref("fig:emergentSchema2"); ?> exemplify quotient graphs for the graph of Figure&nbsp;<?php echo ref("fig:delg"); ?>. Figure&nbsp;<?php echo ref("fig:emergentSchema"); ?> simulates but is not bisimilar to the data graph. Figure&nbsp;<?php echo ref("fig:emergentSchema2"); ?> is bisimilar to the data graph. Often the goal will be to compute the most concise quotient graph that satisfies a given condition; for example, the nodes without outgoing edges in Figure&nbsp;<?php echo ref("fig:emergentSchema2"); ?> could be merged while preserving bisimilarity.</p>
			</div>
		</div>
		</section>

		<section id="sec-identity" class="section">
		<h3>Identity</h3>
		<p>Figure&nbsp;<?php echo ref("fig:delg"); ?> uses nodes like <span class="gnode">Santiago</span>, but to which Santiago does this node refer? Do we refer to Santiago de Chile, Santiago de Cuba, Santiago de Compostela, or do we perhaps refer to the indie rock band Santiago? Based on edges such as <?php echo gedge("Santa&nbsp;Lucía","city","Santiago"); ?>, we may deduce that it is one of the three cities mentioned (not the rock band), and based on the fact that the graph describes tourist attractions in Chile, we may further deduce that it refers to Santiago de Chile. Without further details, however, <em>disambiguating</em> nodes of this form may rely on heuristics prone to error in more difficult cases. To help avoid such ambiguity, first we may use globally-unique identifiers to avoid naming clashes when the knowledge graph is extended with external data, and second we may add external identity links to disambiguate a node with respect to an external source.</p>

		<h4 id="subsec-globalIdentifiers" class="subsection">Persistent identifiers</h4>
		<p>Assume we wished to compare tourism in Chile and Cuba, and we have acquired an appropriate knowledge graph for Cuba similar to the one we have for Chile. We can merge two graphs by taking their union. However, as shown in Figure&nbsp;<?php echo ref("fig:globalIds"); ?>, using an ambiguous node like <span class="gnode">Santiago</span> may yield a <em>naming clash</em>: the node is referring to two different real-world cities in both graphs, where the merged graph indicates that Santiago is a city in both Chile and Cuba (rather than two distinct cities).<?php echo footnote("Such a naming clash is not unique to graphs, but could also occur if merging tables, trees, etc."); ?> To avoid such clashes, long-lasting <em>persistent identifiers</em> (<em>PIDs</em>)&nbsp;<?php echo $references->cite("pids"); ?> can be created in order to uniquely identify an entity; examples of PID schemes include <em>Digital Object Identifiers</em> (<em>DOIs</em>) for papers, <em>ORCID iDs</em> for authors, <em>International Standard Book Numbers</em> (<em>ISBNs</em>) for books, <em>Alpha-2 codes</em> for counties, and more besides.</p>

		<figure id="fig-globalIds">
			<img src="images/fig-globalIds.svg" alt="Result of merging two graphs with ambiguous local identifiers"/>
			<figcaption>Result of merging two graphs with ambiguous local identifiers <a class="git" title="Consult the code for this example on Github" href="https://github.com/Knowledge-Graphs-Book/examples/blob/main/Chapter_3_Schema_Identity_Context/3_2_1_Persistent_identifiers/"></a></figcaption>
		</figure>

		<p>In the context of the Semantic Web, the RDF data model goes one step further and recommends that global Web identifiers be used for nodes and edge labels. However, rather than adopt the <em>Uniform Resource Locators (URLs)</em> used to identify the location of <em>information resources</em> such as webpages, RDF&nbsp;1.1 proposes to use <em>Internationalised Resource Identifiers (IRIs)</em> to identify <em>non-information resources</em> such as cities or events.<?php echo footnote("Uniform Resource Identifiers (URIs) can be Uniform Resource Locators (URLs), used to locate information resources, and Uniform Resource Names (URNs), used to name resources. Internationalised Resource Identifiers (IRIs) are URIs that allow Unicode (e.g., <code>http://example.com/Ñam</code>)."); ?> Hence, for example, in the RDF representation of the Wikidata&nbsp;<?php echo $references->cite("VrandecicK14"); ?> – a knowledge graph proposed to complement Wikipedia, discussed in more detail in Chapter&nbsp;<?php echo ref("chap:kgs"); ?> – while the URL <span class="gnode"><a class="uri" href="https://www.wikidata.org/wiki/Q2887">https://www.wikidata.org/wiki/Q2887</a></span> refers to a webpage that can be loaded in a browser providing human-readable metadata about Santiago, the IRI <span class="gnode"><a class="uri" href="http://www.wikidata.org/entity/Q2887">http://www.wikidata.org/entity/Q2887</a></span> refers to the city itself. Distinguishing the identifiers for the webpage and the city itself avoids naming clashes; for example, if we use the URL to identify both the webpage and the city, we may end up with an edge in our graph, such as (with readable labels below the edge):</p>

		<p class="mathblock uris"><?php echo gedge("<a class=\"uri\" href=\"https://www.wikidata.org/wiki/Q2887\">https://www.wikidata.org/wiki/Q2887</a>","<a class=\"uri\" href=\"https://www.wikidata.org/wiki/Property:P112\">https://www.wikidata.org/wiki/Property:P112</a>","<a class=\"uri\" href=\"https://www.wikidata.org/wiki/Q203534\">https://www.wikidata.org/wiki/Q203534</a>"); ?><br/>
			<code>[Santiago (URL)]</code><code style="margin-left:8em;margin-right:7em;">[founded by (URL)]</code> <code>[Pedro de Valdivia (URL)]</code></p>

		<p>Such an edge leaves ambiguity: was Pedro de Valdivia the founder of the webpage, or the city? Using IRIs for entities distinct from the URLs for the webpages that describe them avoids such ambiguous cases, where Wikidata thus rather defines the previous edge using less ambiguous identifiers, as follows:</p>

		<p class="mathblock uris"><?php echo gedge("<a class=\"uri\" href=\"https://www.wikidata.org/entity/Q2887\">https://www.wikidata.org/entity/Q2887</a>","<a class=\"uri\" href=\"https://www.wikidata.org/prop/direct/P112\">https://www.wikidata.org/prop/direct/P112</a>","<a class=\"uri\" href=\"https://www.wikidata.org/entity/Q203534\">https://www.wikidata.org/entity/Q203534</a>"); ?><br/>
			<code>[Santiago (IRI)]</code><code style="margin-left:8em;margin-right:7em;">[founded by (IRI)]</code> <code>[Pedro de Valdivia (IRI)]</code></p>

		<p>using IRIs for the city, person, and founder of, distinct from the webpages describing them. These Wikidata identifiers use the prefix <a class="uri" href="http://www.wikidata.org/entity/">http://www.wikidata.org/entity/</a> for entities and the prefix <a class="uri" href="http://www.wikidata.org/prop/direct/">http://www.wikidata.org/prop/direct/</a> for relations. Such prefixes are known as <em>namespaces</em>, and are often abbreviated with prefix strings, such as <code>wd:</code> or <code>wdt:</code>, where the latter edge can then be written more concisely using such abbreviations as th edge <?php echo gedge("wd:Q2887","wdt:P112","wd:Q203534"); ?>.</p>
		<p>If HTTP IRIs are used to identify the graph’s entities, when the IRI is looked up (via HTTP), the web-server can return (or redirect to) a description of that entity in formats such as RDF. This further enables RDF graphs to link to related entities described in external RDF graphs over the Web, giving rise to <em>Linked Data</em>&nbsp;<?php echo $references->cite("ldprinciples,ldbook"); ?> (discussed in Chapter&nbsp;<?php echo ref("chap:publish"); ?>). Though HTTP IRIs offer a flexible and powerful mechanism for issuing global identifiers on the Web, they are not necessarily persistent: websites may go offline, the resources described at a given location may change, etc. In order to enhance the persistence of such identifiers, <em>Persistent URL</em> (<em>PURL</em>) services offer redirects from a central server to a particular location, where the PURL can be redirected to a new location if necessary, changing the address of a document without changing its identifier. The persistence of HTTP IRIs can then be improved by using namespaces defined through PURL services.</p>

		<h4 id="sssec-external_identy" class="subsection">External identity links</h4>
		<p>Assume that the tourist board opts to define the <code>chile:</code> namespace with an IRI such as <code>http://turismo.cl/entity/</code> on a web-server that they control, allowing nodes such as <span class="gnode">chile:Santiago</span> – a shortcut for the IRI <span class="gnode"><a class="uri" href="http://turismo.cl/entity/Santiago">http://turismo.cl/entity/Santiago</a></span> – to be looked up over the Web. While using such a naming scheme helps to avoid naming clashes, the use of IRIs does not necessarily help ground the identity of a resource. For example, an external geographic knowledge graph may assign the same city the IRI <span class="gnode">geo:SantiagoDeChile</span> in their own namespace, where we have no direct way of knowing that the two identifiers refer to the same city. If we merge the two knowledge graphs, we will end up with two distinct nodes for the same city, and thus not integrate their data.</p>
		<p>There are a number of ways to ground the identity of an entity. The first is to associate the entity with uniquely-identifying information in the graph, such as its geo-coordinates, its postal code, the year it was founded, etc. Each additional piece of information removes ambiguity regarding which city is being referred to, providing (for example) more options for matching the city with its analogue in external sources. A second option is to use <em>identity links</em> to state that a local entity has the same identity as another <em>coreferent</em> entity found in an external source; an instantiation of this concept can be found in the OWL standard, which defines the <code>owl:sameAs</code> property relating coreferent entities. Using this property, we could state the edge <?php echo gedge("chile:Santiago","owl:sameAs","geo:SantiagoDeChile"); ?> in our RDF graph, thus establishing an identity link between the corresponding nodes in both graphs. Rather than specifying pairwise identity links between all knowledge graphs, it suffices if two knowledge graphs provide corresponding identity links to the same external knowledge graph, such as DBpedia or Wikidata; for example, if the local knowledge graph provides an identity link to Wikidata indicating <?php echo gedge("chile:Santiago","owl:sameAs","wd:Q2887"); ?>, while the remote knowledge graph has the identity link <?php echo gedge("geo:SantiagoDeChile","owl:sameAs","wd:Q2887"); ?>, then we can infer <?php echo gedge("chile:Santiago","owl:sameAs","geo:SantiagoDeChile"); ?>. The semantics of <code>owl:sameAs</code> defined by the OWL standard then allows us to combine the data for both nodes. Such semantics will be discussed later in Chapter&nbsp;<?php echo ref("chap:deductive"); ?>. Ways in which identity links can be computed will also be discussed later in Chapter&nbsp;<?php echo ref("chap:refine"); ?>.</p>

		<h4 id="sssec-datatypes" class="subsection">Datatypes</h4>
		<p>Consider the two date-times on the left of Figure&nbsp;<?php echo ref("fig:delg"); ?>: how should we assign these nodes persistent/global identifiers? Intuitively it would not make much sense, for example, to assign IRIs to these nodes since their syntactic form tells us what they refer to: specific dates and times in March 2020. This syntactic form is further recognisable by machine, meaning that with appropriate software, we could order such values in ascending or descending order, extract the year, etc.</p>
		<p>Most practical data models for graphs allow for defining nodes that are datatype values. RDF utilises <em>XML Schema Datatypes</em> (<em>XSD</em>)&nbsp;<?php echo $references->cite("XSD"); ?>, amongst others, where a datatype node is given as a pair \((l,d)\) where \(l\) is a lexical string, such as "<code>2020-03-29T20:00:00</code>", and \(d\) is an IRI denoting the datatype, such as <code>xsd:dateTime</code>. The node is then denoted <span class="gnode">"<code>2020-03-29T20:00:00</code>"^^xsd:dateTime</span>. Datatype nodes in RDF are called <em>literals</em> and are not allowed to have outgoing edges. Other datatypes commonly used in RDF data include <code>xsd:string</code>, <code>xsd:integer</code>, <code>xsd:decimal</code>, <code>xsd:boolean</code>, etc. If the datatype is omitted, the value is assumed to be of type <code>xsd:string</code>. Applications built on top of RDF can then recognise these datatypes, parse them into datatype objects, and apply equality checks, normalisation, ordering, transformations, etc., according to their standard definition. In the context of property graphs, Neo4j&nbsp;<?php echo $references->cite("Miller13"); ?> also defines a set of internal datatypes on property values that includes numbers, strings, Booleans, spatial points, and temporal values.</p>

		<h4 id="sssec-lexicalisation" class="subsection">Lexicalisation</h4>
		<p>Global identifiers for entities will sometimes have a human-interpretable form, such as <span class="gnode">chile:Santiago</span>, but the identifier strings themselves do not carry any formal semantic significance. In other cases, the identifiers used may not be human-interpretable by design. In Wikidata, for instance, Santiago de Chile is identified as <span class="gnode">wd:Q2887</span>, where such a scheme has the advantage of providing better persistence and of not being biased to a particular human language. As a real-world example, the Wikidata identifier for Eswatini (<span class="gnode">wd:Q1050</span>) was not affected when the country changed its name from Swaziland, and does not necessitate choosing between languages for creating (more readable) IRIs such as <span class="gnode">wd:Eswatini</span> (English), <span class="gnode">wd:eSwatini</span> (Swazi), <span class="gnode">wd:Esuatini</span> (Spanish), etc.</p>
		<p>Since identifiers can be arbitrary, it is common to add edges that provide a human-interpretable label for nodes, such as <?php echo gedge("wd:Q2887","rdfs:label","&apos;Santiago&apos;"); ?>, indicating how people may refer to the subject node linguistically. Linguistic information of this form plays an important role in grounding knowledge such that users can more clearly identify which real-world entity a particular node in a knowledge graph actually references&nbsp;<?php echo $references->cite("Lexvo"); ?>; it further permits cross-referencing entity labels with text corpora to find, for example, documents that potentially speak of a given entity&nbsp;<?php echo $references->cite("IESW"); ?>. Labels can be complemented with aliases (e.g., <?php echo gedge("wd:Q2887","skos:altLabel","&apos;Santiago&nbsp;de&nbsp;Chile&apos;"); ?>) or comments (e.g. <?php echo gedge("wd:Q2887","rdfs:comment","&apos;Santiago&nbsp;is&nbsp;the&nbsp;capital&nbsp;of&nbsp;Chile&apos;"); ?>) to further help ground the node’s identity.</p>
		<p>Nodes such as <span class="gnode">&apos;Santiago&apos;</span> denote string literals, rather than an identifier. Depending on the specific graph model, such literal nodes may also be defined as a pair \((s,l)\), where \(s\) denotes the string and \(l\) a language code; in RDF, for example we may state <?php echo gedge("chile:City","rdfs:label","&apos;City&apos;@en"); ?>, <?php echo gedge("chile:City","rdfs:label","&apos;Ciudad&apos;@es"); ?>, etc., indicating labels for the node in different languages. In other models, the pertinent language can rather be specified, e.g., via metadata on the edge. Knowledge graphs with human-interpretable labels, aliases, comments, etc., (in various languages) are sometimes called (<em>multilingual</em>) <em>lexicalised knowledge graphs</em>&nbsp;<?php echo $references->cite("BonattiDPP18"); ?>".</p>

		<h4 id="sssec-existential" class="subsection">Existential nodes</h4>
		<p>When modelling incomplete information, we may in some cases know that there must exist a particular node in the graph with particular relationships to other nodes, but without being able to identify the node in question. For example, we may have two co-located events <span class="gnode">chile:EID42</span> and <span class="gnode">chile:EID43</span> whose venue has yet to be announced. One option is to simply omit the venue edges, in which case we lose the information that these events have a venue and that both events have the same venue. Another option might be to create a fresh IRI representing the venue, but semantically this becomes indistinguishable from there being a known venue. Hence some graph models permit the use of existential nodes, represented here as a blank circle:</p>

		<p class="mathblock"><span class="gnode">chile:EID42</span><?php echo esource(); ?><span class="edge">chile:venue</span><?php echo etipr(); ?><span class="gnode">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span><?php echo etipl(); ?><span class="edge">chile:venue</span><?php echo esource(); ?><span class="gnode">chile:EID43</span></p>

		<p>These edges denote that there exists a common venue for <span class="gnode">chile:EID42</span> and <span class="gnode">chile:EID42</span> without identifying it. Existential nodes are supported in RDF as blank nodes&nbsp;<?php echo $references->cite("rdf11"); ?>, which are also commonly used to support modelling complex elements in graphs, such as <em>RDF lists</em>&nbsp;<?php echo $references->cite("rdf11,HoganAMP14"); ?>. Figure&nbsp;<?php echo ref("fig:list"); ?> exemplifies an RDF list, which uses blank nodes in a linked-list structure to encode order. Though existential nodes can be convenient, their presence can complicate operations on graphs, such as deciding if two data graphs have the same structure modulo existential nodes&nbsp;<?php echo $references->cite("rdf11,Hogan17"); ;?>. Hence methods for <em>skolemising</em> existential nodes in graphs – replacing them with canonical labels – have been proposed&nbsp;<?php echo $references->cite("canon,Hogan17"); ?>. Other authors rather call to minimise the use of such nodes in graph data&nbsp;<?php echo $references->cite("ldbook"); ?>.</p>

		<figure id="fig-list">
			<img src="images/fig-list.svg" alt="RDF list representing the three largest peaks of Chile, in order"/>
			<figcaption>RDF list representing the three largest peaks of Chile, in order <a class="git" title="Consult the code for this example on Github" href="https://github.com/Knowledge-Graphs-Book/examples/blob/main/Chapter_3_Schema_Identity_Context/3_2_5_Existential_nodes/"></a></figcaption>
		</figure>
		</section>

		<section id="ssec-knowledgeContext" class="section">
		<h3>Context</h3>
		<p>Many (arguably <em>all</em>) facts presented in the data graph of Figure&nbsp;<?php echo ref("fig:delg"); ?> can be considered true with respect to a certain <em>context</em>. With respect to <em>temporal context</em>, <span class="gnode">Santiago</span> has existed as a city since 1541, flights from <span class="gnode">Arica</span> to <span class="gnode">Santiago</span> began in 1956, etc. With respect to <em>geographic context</em>, the graph describes events in Chile. With respect to <em>provenance</em>, data relating to <span class="gnode">EID15</span> were taken from – and are thus said to be true with respect to – the Ñam webpage on January 4<sup>th</sup>, 2020. Other forms of context may also be used. We may further combine contexts, such as to indicate that <span class="gnode">Arica</span> is a Chilean city (<em>geographic</em>) since 1883 (<em>temporal</em>) per the Treaty of Ancón (<em>provenance</em>).</p>
		<p>By context we herein refer to the <em>scope of truth</em>, i.e., the context in which some data are held to be true&nbsp;<?php echo $references->cite("McCarthy93,GuhaMF04"); ?>. The graph of Figure&nbsp;<?php echo ref("fig:delg"); ?> leaves much of its context implicit. However, making context explicit can allow for interpreting the data from different perspectives, such as to understand what held true in 2016, what holds true excluding webpages later found to have spurious data, etc. As seen previously, context for graph data may be considered at different levels: on individual nodes, individual edges, or sets of edges (sub-graphs). We now discuss various representations by which context can be made explicit at different levels.</p>

		<h4 id="sssec-direct-representation" class="subsection">Direct representation</h4>
		<p>The first way to represent context is to consider it as data no different from other data. For example, the dates for the event <span class="gnode">EID15</span> in Figure&nbsp;<?php echo ref("fig:delg"); ?> can be seen as representing a form of temporal context, indicating the temporal scope within which edges such as <?php echo gedge("EID15","venue","Santa&nbsp;Lucía"); ?> are held true. Another option is to change a relation represented as an edge, such as <?php echo gedge("Santiago","flight","Arica"); ?>, into a node, such as seen in Figure&nbsp;<?php echo ref("fig:fsa"); ?>, allowing us to assign additional context to the relation. While in these examples context is represented in an ad hoc manner, a number of specifications have been proposed to represent context as data in a more standard way. One example is the <em>Time Ontology</em>&nbsp;<?php echo $references->cite("timeOnt"); ?>, which specifies how temporal entities, intervals, time instants, etc. – and relations between them such as <em>before</em>, <em>overlaps</em>, etc. – can be described in RDF graphs in an interoperable manner. Another example is the <em>PROV Data Model</em>&nbsp;<?php echo $references->cite("prov13"); ?>, which specifies how provenance can be described in RDF graphs, where entities (e.g., graphs, nodes, physical document) are derived from other entities, are generated and/or used by activities (e.g., extraction, authorship), and are attributed to agents (e.g., people, software, organisations).</p>

		<h4 id="sec-reify" class="subsection">Reification</h4>
		<p>Often we may wish to directly define the context of edges themselves; for example, we may wish to state that the edge <?php echo gedge("Santiago","flight","Arica"); ?> is valid from 1956. While we could use the pattern of turning the edge into a node – as illustrated in Figure&nbsp;<?php echo ref("fig:fsa"); ?> – to directly represent such context, another option is to use <em>reification</em>, which allows for making statements about statements in a generic manner (or in the case of a graph, for defining edges about edges). In Figure&nbsp;<?php echo ref("fig:temporal"); ?> we present three forms of reification that can be used for modelling temporal context on the aforementioned edge within a directed edge-labelled graph&nbsp;<?php echo $references->cite("HernandezHK15"); ?>. We use \(e\) to denote an arbitrary identifier representing the edge itself to which the context can be associated. Unlike in a direct representation, \(e\) represents an edge, not a flight. RDF reification&nbsp;<?php echo $references->cite("RDFS"); ?> (Figure&nbsp;<?php echo ref("fig:reif"); ?>) defines a new node <span class="gnode">\(e\)</span> to represent the edge and connects it to the source node (via <span class="gelab">subject</span>), target node (via <span style="white-space:nowrap;"><span class="gelab">object</span>),</span> and edge label (via <span class="gelab">predicate</span>) of the edge. In contrast, \(n\)-ary relations&nbsp;<?php echo $references->cite("RDFS"); ?> (Figure&nbsp;<?php echo ref("fig:nary"); ?>) connect the source node of the edge directly to the edge node <span class="gnode">\(e\)</span> with the label of the edge; the target node of the edge is then connected to <span class="gnode">\(e\)</span> (via <span class="gelab">value</span>). Finally, singleton properties&nbsp;<?php echo $references->cite("Nguyen14"); ?> (Figure&nbsp;<?php echo ref("fig:singprop"); ?>) rather use <span class="gelab">\(e\)</span> as an edge label, connecting it to a node indicating the original edge label (via <span class="gelab">singleton</span>). Other forms of reification have been proposed in the literature, including, for example, NdFluents&nbsp;<?php echo $references->cite("Gimenez-GarciaZ17"); ?>. In general, a reified edge does not assert the edge it reifies; for example, we may reify an edge to state that it is no longer valid. We refer to <?php echo $references->citet("HernandezHK15"); ?> for further comparison of reification alternatives.</p>

		<figure id="fig-temporal">
			<figure id="fig-reif" style="display:inline-block;margin-right:2.5em;margin-left:0;">
				<img src="images/fig-reif.svg" alt="RDF Reification"/>
				<figcaption>RDF Reification <a class="git" title="Consult the code for this example on Github" href="https://github.com/Knowledge-Graphs-Book/examples/blob/main/Chapter_3_Schema_Identity_Context/3_3_2_Reification/figure_3_8_a.ttl"></a></figcaption>
			</figure>
			<figure id="fig-nary" style="display:inline-block;">
				<img src="images/fig-nary.svg" alt="n-ary Relations"/>
				<figcaption>\(n\)-ary Relations <a class="git" title="Consult the code for this example on Github" href="https://github.com/Knowledge-Graphs-Book/examples/blob/main/Chapter_3_Schema_Identity_Context/3_3_2_Reification/figure_3_8_b.ttl"></a></figcaption>
			</figure>
			<figure id="fig-singprop" style="display:inline-block;margin-right:0;margin-left:2em;">
				<img src="images/fig-singprop.svg" alt="Singleton properties"/>
				<figcaption>Singleton properties <a class="git" title="Consult the code for this example on Github" href="https://github.com/Knowledge-Graphs-Book/examples/blob/main/Chapter_3_Schema_Identity_Context/3_3_2_Reification/figure_3_8_c.ttl"></a></figcaption>
			</figure>
			<figcaption>Three representations of temporal context on a directed labelled edge</figcaption>
		</figure>

		<h4 id="sssec-higher-arity" class="subsection">Higher-arity representation</h4>
		<p>As an alternative to reification, we can rather use higher-arity representations for modelling context. Taking again the edge <?php echo gedge("Santiago","flight","Arica"); ?>, Figure&nbsp;<?php echo ref("fig:temporal2"); ?> illustrates three higher-arity representations of temporal context. First, we can use a named graph (Figure&nbsp;<?php echo ref("fig:ngraph"); ?>) to contain the edge and then define the temporal context on the graph name. Second, we can use a property graph (Figure&nbsp;<?php echo ref("fig:pgc"); ?>) where the temporal context is defined as a property on the edge. Third, we can use <em>RDF*</em>&nbsp;<?php echo $references->cite("Hartig17"); ?> (Figure&nbsp;<?php echo ref("fig:rdfstar"); ?>): an extension of RDF that allows edges to be defined as nodes. Amongst these options, the most flexible is the named graph representation, where we can assign context to multiple edges at once by placing them in one named graph; for example, we can add more edges to the named graph of Figure&nbsp;<?php echo ref("fig:ngraph"); ?> that are also valid from 1956. The least flexible option is RDF*, which, in the absence of an edge id, does not permit different groups of contextual values to be assigned to an edge; for example, if we add four contextual values to the edge <?php echo gedge("Chile","president","M.&nbsp;Bachelet"); ?>, to state that it was valid from 2006 until 2010 and valid from 2014 until 2018, we cannot pair the values, but may rather have to create a node to represent different presidencies (in the other models, we could have used two named graphs or edge ids).</p>

		<figure id="fig-temporal2">
			<figure id="fig-ngraph" style="display:inline-block;margin-right:2.5em;margin-left:0;">
				<img src="images/fig-ngraph.svg" alt="Named graph"/>
				<figcaption>Named graph <a class="git" title="Consult the code for this example on Github" href="https://github.com/Knowledge-Graphs-Book/examples/blob/main/Chapter_3_Schema_Identity_Context/3_3_3_Higher_arity_representation/figure_3_9_a.trig"></a></figcaption>
			</figure>
			<figure id="fig-pgc" style="display:inline-block;">
				<img src="images/fig-pgc.svg" alt="Property graph"/>
				<figcaption>Property graph <a class="git" title="Consult the code for this example on Github" href="https://github.com/Knowledge-Graphs-Book/examples/blob/main/Chapter_3_Schema_Identity_Context/3_3_3_Higher_arity_representation/figure_3_9_b.cypher"></a></figcaption>
			</figure>
			<figure id="fig-rdfstar" style="display:inline-block;margin-right:0;margin-left:2em;">
				<img src="images/fig-rdfstar.svg" alt="RDF*"/>
				<figcaption>RDF* <a class="git" title="Consult the code for this example on Github" href="https://github.com/Knowledge-Graphs-Book/examples/blob/main/Chapter_3_Schema_Identity_Context/3_3_3_Higher_arity_representation/figure_3_9_c.rdfstar"></a></figcaption>
			</figure>
			<figcaption>Three higher-arity representations of temporal context on an edge</figcaption>
		</figure>

		<h4 id="sssec-annotations" class="subsection">Annotations</h4>
		<p>Thus far, we have discussed representing context in a graph, but we have not spoken about automated mechanisms for reasoning about context; for example, if there are only seasonal summer flights from <span class="gnode">Santiago</span> to <span class="gnode">Arica</span>, we may wish to find other routes from Santiago for winter events taking place in <span class="gnode">Arica</span>. While the dates for buses, flights, etc., can be represented directly in the graph, or using reification, writing a query to manually intersect the corresponding temporal contexts will be difficult. An alternative is to consider <em>annotations</em> that provide mathematical definitions of a contextual domain and key operations over that domain that can be applied automatically.</p>
		<p>Some annotations model a particular contextual domain; for example, <em>Temporal RDF</em>&nbsp;<?php echo $references->cite("GutierrezHV07"); ?> allows for annotating edges with time intervals, such as <?php echo sedge("Chile","president","[2006,2010]","M.&nbsp;Bachelet","gnode"); ?>, while <em>Fuzzy RDF</em>&nbsp;<?php echo $references->cite("Straccia09"); ?> allows for annotating edges with a degree of truth such as <?php echo sedge("Santiago","climate","0.8","Semi-Arid","gnode"); ?>, indicating that it is more-or-less true – with a degree of \(0.8\) – that Santiago has a semi-arid climate.</p>
		<p>Other forms of annotation are domain-independent; for example, <em>Annotated RDF</em>&nbsp;<?php echo $references->cite("Dividino09,UdreaRS10,zimm-etal-2012-JWS"); ?> allows for representing context modelled as <em>semi-rings</em>: algebraic structures consisting of domain values (e.g., temporal intervals, fuzzy values, etc.) and two operators to combine domain values: <em>meet</em> and <em>join</em>.<?php echo footnote("The <em>join</em> operator for annotations is different from the join operator for relational algebra."); ?> We provide an example in Figure&nbsp;<?php echo ref("fig:time"); ?>, where \(G\) is annotated with values from a temporal domain using sets of integers (\(1{-}365\) to represent days of the year. For brevity we use intervals, where, e.g., \(\{[150,152]\}\) denotes the set \(\{150,151,152\}\). Query \(Q\) then asks for flights from Santiago to cities with events; this query will check and return an annotation reflecting the temporal validity of each answer. To derive these answers, we require a conjunction of annotations on compatible <span class="gelab">flight</span> and <span class="gelab">city</span> edges, using the <em>meet operator</em> to compute the annotation for which both edges hold. The natural way to define meet here is as the intersection of sets of days, where, for example, applying meet on the event annotation \(\color{blue}\{[150,152]\}\) and the flight annotation \(\color{blue}\{[1,120],[220,365]\}\) for <span class="gnode">Punta Arenas</span> leads to the empty time interval \(\color{blue}\{\}\), which may thus lead to the city being filtered from the results (depending on the query evaluation semantics). However, for <span class="gnode">Arica</span>, we find two different non-empty intersections: \(\color{blue}\{[123,125]\}\) for <span class="gnode">EID16</span> and \(\color{blue}\{[276,279]\}\) for <span class="gnode">EID17</span>. Given that we are interested in just the city (a projected variable), we can combine the two annotations for <span class="gnode">Arica</span> using the <em>join operator</em>, returning the annotation in which either result holds true. The natural way to define join is as the union of the sets of days, giving \(\color{blue}\{[123,125],[276,279]\}\).</p>

		<figure id="fig-time">
			<img src="images/fig-time1.svg" alt="Temporally annotated graph" class="multi"/>
			<img src="images/fig-time2.svg" alt="Example query"/>
			<div><div style="display:inline;">\(Q(G) :\) <table class="condensedTable" style="position:relative;top:.6em;display:inline-block;vertical-align:middle;"><thead><tr><th>?city</th><th>context</th></tr></thead><tbody><tr><td><code>Arica</code></td><td>\(\color{blue}\{[123,125],[276,279]\}\)</td></tr></tbody></table></div></div>
			<figcaption>Example query on a temporally annotated graph <a class="git" title="Consult the code for this example on Github" href="https://github.com/Knowledge-Graphs-Book/examples/blob/main/Chapter_3_Schema_Identity_Context/3_3_4_Annotations/"></a></figcaption>
		</figure>

		<div class="formal">
			<p>We define an annotation domain per <?php echo $references->citet("zimm-etal-2012-JWS"); ?>.</p>

			<dl class="definition" id="def-anndom">
				<dt>Annotation domain</dt>
				<dd>Let \(A\) be a set of <em>annotation values</em>. An <em>annotation domain</em> is an idempotent, commutative semi-ring \(D = \langle A,\oplus,\otimes,\bot,\top \rangle\).</dd>
			</dl>

			<p>This definition can then instantiate specific domains of context.</p>
			<p>Letting \(D\) be a semi-ring imposes that, for any values \(a, a_1, a_2, a_3\) in \(A\), the following hold:</p>
			<ul>
				<li>\((a_1 \oplus a_2) \oplus a_3 = a_1 \oplus (a_2 \oplus a_3)\)</li>
				<li>\((\bot \oplus a) = (a \oplus \bot) = a\)</li>
				<li>\((a_1 \oplus a_2) = (a_2 \oplus a_1)\)</li>
				<li>\((a_1 \oplus a_2) = (a_2 \oplus a_1)\)</li>
				<li>\((a_1 \otimes a_2) \otimes a_3 = a_1 \otimes (a_2 \otimes a_3)\)</li>
				<li>\((\top \otimes a) = (a \otimes \top) = a\)</li>
				<li>\(a_1 \otimes (a_2 \oplus a_3) = (a_1 \otimes a_2) \oplus (a_1 \otimes a_3)\)</li>
				<li>\((a_1 \oplus a_2) \otimes a_3 = (a_1 \otimes a_3) \oplus (a_2 \otimes a_3)\)</li>
				<li>\((\bot \otimes a) = (a \otimes \bot) = \bot\)</li>
			</ul>
			<p>The requirement that it be idempotent further imposes the following:</p>
			<ul>
				<li>\((a \oplus a) = a\)</li>
			</ul>
			<p>Finally, the requirement that it be commutative imposes the following:</p>
			<ul>
				<li>\((a_1 \otimes a_2) = (a_2 \otimes a_1)\)</li>
			</ul>
			<p>Idempotence induces a partial order: \(a_1 \leq a_2\) if and only if \(a_1 \oplus a_2 = a_2\). Imposing these conditions on the annotation domain allow for reasoning and querying to be conducted over the annotation domain in a well-defined manner. Annotated graphs can then be defined in the natural way:</p>

			<dl class="definition" id="def-annotated-directed-edge-labelled-graph">
				<dt>Annotated directed edge-labelled graph</dt>
				<dd>Letting \(D = \langle A,\oplus,\otimes,\bot,\top \rangle\) denote an idempotent, commutative semi-ring, we define an <em>annotated directed edge-labelled graph</em> (or <em>annotated directed edge-labelled graph</em>) as \(G = (V,E_A,L)\) where \(V \subseteq \con\) is a set of nodes, \(L \subseteq \con\) is a set of edge labels, and \(E_A \subseteq V \times L \times V \times A\) is a set of edges annotated with values from \(A\).</dd>
			</dl>

			<div class="example">
				<p>Figure&nbsp;<?php echo ref("fig:time"); ?> exemplifies query answering on a graph annotated with days of the year. Formally this domain can be defined as follows: \(A \coloneqq 2^{\mathbb{N}_{[1,365]}}\), \(\oplus \coloneqq \cup\), \(\otimes \coloneqq \cap\), \(\top \coloneqq \mathbb{N}_{[1,365]}\), \(\bot \coloneqq \emptyset\), where one may verify that \(D = \langle 2^{\mathbb{N}_{[1,365]}}, \cup, \cap, \mathbb{N}_{[1,365]}, \emptyset \rangle\) is indeed an idempotent, commutative semi-ring.</p>
			</div>
		</div>

		<h4 id="sssec-other-context" class="subsection">Other contextual frameworks</h4>
		<p>Other frameworks have been proposed for modelling and reasoning about context in graphs. A notable example is that of <em>contextual knowledge repositories</em>&nbsp;<?php echo $references->cite("SerafiniH12"); ?>, which allow for assigning individual (sub-)graphs to their own context. Unlike in the case of named graphs, context is explicitly modelled along one or more dimensions, where each (sub-)graph takes a value for each dimension. Each dimension is associated with a partial order over its values – e.g., <span class="gnode">2020-03-22</span> \(\preceq\) <span class="gnode">2020-03</span> \(\preceq\) <span class="gnode">2020</span> – enabling the selection and combination of sub-graphs that are valid within contexts at different granularities. <?php echo $references->citet("SchuetzBNSS20"); ?> similarly propose a form of contextual OnLine Analytic Processing (OLAP), based on a data cube formed by dimensions where each cell contains a knowledge graph. Operations such as “<em>slice-and-dice</em>” (selecting knowledge according to given dimensions), as well as “<em>roll-up</em>” (aggregating knowledge at a higher level) are supported. We refer the reader to the respective papers for more details&nbsp;<?php echo $references->cite("SerafiniH12,SchuetzBNSS20"); ?>.</p>
		</section>
	</section>
