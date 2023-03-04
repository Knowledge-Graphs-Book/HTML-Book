	<section id="chap-graph" class="chapter">
		<h2>Data Graphs</h2>
		<p>At the foundation of any knowledge graph is the principle of first applying a graph abstraction to data, resulting in an initial data graph. We now discuss a selection of graph-structured data models that are commonly used in practice to represent data graphs. We then discuss the primitives that form the basis of graph query languages used to interrogate such data graphs.</p>

		<section id="ssec-graphModels" class="section">
		<h3>Models</h3>
		<p>Leaving aside graphs, let us assume that the tourism board from our running example has not yet decided how to model relevant data about attractions, events, services, etc. The board first considers using a tabular structure – in particular, relational databases – to represent the required data, and though they do not know precisely what data they will need to capture, they begin to design an initial relational schema. They begin with an <span class="sf">Event</span> table with five columns:</p>

		<p class="mathblock"><span class="sf">Event</span>(<span class="sf underline">name</span>, <span class="sf">venue</span>, <span class="sf">type</span>, <span class="sf underline">start</span>, <span class="sf">end</span>)</p>

		<p>where <span class="sf underline">name</span> and <span class="sf underline">start</span> together form the primary key of the table in order to uniquely identify recurring events. But as they start to populate the data, they encounter various issues: events may have multiple names (e.g., in different languages), events may have multiple venues, they may not yet know the start and end date-times for future events, events may have multiple types, and so forth. Incrementally addressing these modelling issues as the data become more diverse, they generate internal identifiers for events and adapt their relational schema until they have:</p>

		<p class="mathblock" id="al-schema"><span class="sf">EventName</span>(<span class="sf underline">id</span>,<span class="sf underline">name</span>), <span class="sf">EventStart</span>(<span class="sf underline">id</span>,<span class="sf">start</span>), <span class="sf">EventEnd</span>(<span class="sf underline">id</span>,<span class="sf">end</span>), <span class="sf">EventVenue</span>(<span class="sf underline">id</span>,<span class="sf underline">venue</span>), <span class="sf">EventType</span>(<span class="sf underline">id</span>,<span class="sf underline">type</span>)<span style="float: right;">(2.1)</span></p>

		<p>With the above schema, the organisation can now model events with \(0{-}n\) names, venues, and types, and \(0{-}1\) start dates and end dates (without needing relational nulls).</p>
		<p>Along the way, the board has to incrementally change the schema several times in order to support new sources of data. Each such change requires a costly remodelling, reloading, and reindexing of data; here we only considered one table. The tourism board struggles with the relational model because they do not know, <em>a priori</em>, what data will need to be modelled or what sources they will use. But once they reach the latter relational schema, the board finds that they can integrate further sources without more changes: with minimal assumptions on <em>multiplicities</em> (\(1{-}1\), \(1{-}n\), etc.) this schema offers a lot of flexibility for integrating incomplete and diverse data.</p>
		<p>In fact, the refined, flexible schema that the board ends up with – as shown in (<? echo ref("al:schema"); ?>) – is modelling a set of binary relations between entities, which indeed can be viewed as modelling a graph. By instead adopting a graph data model from the outset, the board could forgo the need for an upfront schema, and could define any (binary) relation between any pair of entities at any time.</p>
		<p>We now introduce graph data models popular in practice&nbsp;<? echo $references->cite("AnglesABHRV17"); ?>.</p>

		<h4 id="sssec-directedelg" class="subsection">Directed edge-labelled graphs</h4>
		<p>A directed edge-labelled graph (sometimes known as a <em>multi-relational graph</em>&nbsp;<? echo $references->cite("nickel2013tensor,bordes2013translating,BalazevicAH19"); ?>) is defined as a set of nodes – like <span class="gnode">Santiago</span>, <span class="gnode">Arica</span>, <span style="white-space:nowrap;"><span class="gnode">EID16</span>,</span> <span class="gnode">2018-03-22&nbsp;12:00</span> – and a set of directed labelled edges between those nodes, like <? echo gedge("Santa&nbsp;Lucía","city","Santiago"); ?>. In the case of knowledge graphs, nodes are used to represent entities and edges are used to represent (binary) relations between those entities. Figure&nbsp;<? echo ref("fig:delg"); ?> provides an example of how the tourism board could model some relevant event data as a directed edge-labelled graph. The graph includes data about the names, types, start and end date-times, and venues for events.<? echo footnote("We represent bidirectional edges as ". gedge("Viña&nbsp;del&nbsp;Mar","bus","Arica",LEFTRIGHTARROW) .", which more concisely depicts two directed edges: ". gedge("Viña&nbsp;del&nbsp;Mar","bus","Arica") ." and ". gedge("Viña&nbsp;del&nbsp;Mar","bus","Arica",LEFTARROW). ". Also while some naming conventions recommend more complete edge labels that include a verb, such as <span class=\"gelab\">has venue</span> or <span class=\"gelab\">is valid from</span>, in this book, for presentation purposes, we will omit the “<code>has</code>” and “<code>is</code>” verbs from such labels, using simply <span class=\"gelab\">venue</span> or <span class=\"gelab\">valid&nbsp;from</span>."); ?> Adding information to such a graph typically involves adding new nodes and edges (with some exceptions discussed later). Representing incomplete information requires simply omitting a particular edge; for example, the graph does not yet define a start/end date-time for the Food Truck festival.</p>
		
		<figure id="fig-delg">
			<img src="images/fig-delg.svg" alt="Directed edge-labelled graph describing events and their venues" />
			<figcaption>Directed edge-labelled graph describing events and their venues <a class="git" title="Consult the code for this example on Github" href="https://github.com/Knowledge-Graphs-Book/examples/tree/main/Chapter_2_Data_Graphs/2_1_1_Directed_edge_labelled_graphs/figure_2_1.ttl"></a></figcaption>
		</figure>

		<p>Modelling data as a graph in this way offers more flexibility for integrating new sources of data, compared to the standard relational model, where a schema must be defined upfront and followed at each step. While other structured data models such as trees (XML, JSON, etc.) would offer similar flexibility, graphs do not require organising the data hierarchically (should <code>venue</code> be a parent, child, or sibling of <code>type</code> for example?). They also allow cycles to be represented and queried (e.g., note the directed cycle in the routes between Santiago, Arica, and Viña del Mar).</p>
		<p>A standardised data model based on directed edge-labelled graphs is the Resource Description Framework (RDF)&nbsp;<? echo $references->cite("rdf11"); ?>, which has been recommended by the W3C. The RDF model defines different types of nodes, including <em>Internationalized Resource Identifiers</em> (IRIs)&nbsp;<? echo $references->cite("rfc3987"); ?> which allow for global identification of entities on the Web; <em>literals</em>, which allow for representing strings (with or without language tags) and other datatype values (integers, dates, etc.); and <em>blank nodes</em>, which are anonymous nodes that are not assigned an identifier (for example, rather than create internal identifiers like <code>EID15</code>, <code>EID16</code>, in RDF, we have the option to use blank nodes). We will discuss these different types of nodes further in Section&nbsp;<? echo ref("sec:identity"); ?> when we speak about issues relating to identity.</p>

		<div class="formal">
			<p>We now formally define a directed edge-labelled graph, where we denote by \(\con\) a countably infinite set of constants.</p>

			<dl class="definition" id="def-delg">
				<dt>Directed edge-labelled graph</dt>
				<dd>A <em>directed edge-labelled graph</em> is a tuple \(G = (V,E,L)\), where \(V \subseteq \con\) is a set of nodes, \(L \subseteq \con\) is a set of edge labels, and \(E \subseteq V \times L \times V\) is a set of edges.</dd>
			</dl>

			<div class="example">
				<p>In reference to Figure&nbsp;<? echo ref("fig:delg"); ?>, the set of nodes \(V\) has 15 elements, including <code>Arica</code>, <code>EID16</code>, etc. The set of edges \(E\) has 23 triples, including (<code>Arica</code>, <code>flight</code>, <code>Santiago</code>). Bidirectional edges are represented with two edges. The set of edge labels \(L\) has 8 elements, including <code>start</code>, <code>flight</code>, etc.</p>
			</div>
			
			<p>Definition&nbsp;<? echo ref("def:delg"); ?> does not state that \(V\) and \(L\) are disjoint: though not present in the example, a node can also serve as an edge-label. The definition also permits that nodes and edge labels can be present without any associated edge. Either restriction could be explicitly stated – if necessary – in a particular application while still conforming to a directed edge-labelled graph.</p>
			<p>For ease of presentation, we may treat a set of (directed labelled) edges \(E \subseteq V \times L \times V\) as a directed edge-labelled graph \((V,E,L)\), in which case we refer to the graph induced by \(E\) assuming that \(V\) and \(L\) contain all and only those nodes and edge labels, respectively, used in \(E\). We may similarly apply set operators on directed edge-labelled graphs, which should be interpreted as applying to their sets of edges; for example, given \(G_1 = (V_1,E_1,L_1)\) and \(G_2 = (V_2,E_2,L_2)\), by \(G_1 \cup G_2\) we refer to the directed edge-labelled graph induced by \(E_1 \cup E_2\).</p>
		</div>

		<h4 id="subsub-heterograph" class="subsection">Heterogeneous graphs</h4>
		<p>A heterogeneous graph&nbsp;<? echo $references->cite("HusseinYC18,WangJSWYCY19,YangXJWHW20"); ?> (or <em>heterogeneous information network</em>&nbsp;<? echo $references->cite("sun2011pathsim,2012Sun"); ?>) is a directed graph where each node and edge is assigned one type. Heterogeneous graphs are thus akin to directed edge-labelled graphs – with edge labels corresponding to edge types – but where the type of node forms part of the graph model itself, rather than being expressed with a relation (as seen in Figure&nbsp;<? echo ref("fig:capital"); ?>). An edge is called <em>homogeneous</em> if it is between two nodes of the same type (e.g., <span class="gelab">borders</span> in Figure&nbsp;<? echo ref("fig:capital"); ?>); otherwise it is called <em>heterogeneous</em> (e.g., <span class="gelab">capital</span> in Figure&nbsp;<? echo ref("fig:capital"); ?>). Heterogeneous graphs allow for partitioning nodes according to their type, for example, for the purposes of machine learning tasks&nbsp;<? echo $references->cite("HusseinYC18,WangJSWYCY19,YangXJWHW20"); ?>. Conversely, such graphs typically only support a one-to-one relation between nodes and types, which is not the case for directed edge-labelled graphs (see, for example, the node <span class="gnode">Santiago</span> with zero types and <span class="gnode">EID15</span> with multiple types in Figure&nbsp;<? echo ref("fig:delg"); ?>).</p>
		
		<figure id="fig-capital">
			<figure id="fig-cap">
				<img src="images/fig-cap.svg" alt="Del graph"/>
				<figcaption>Directed edge-labelled graph <a class="git" title="Consult the code for this example on Github" href="https://github.com/Knowledge-Graphs-Book/examples/blob/main/Chapter_2_Data_Graphs/2_1_2_Heterogeneous_graphs/figure_2_2_a.ttl"></a></figcaption>
			</figure>
			<figure id="fig-hg">
				<img src="images/fig-hg.svg" alt="Heterogenous graph"/>
				<figcaption>Heterogenous graph <a class="git" title="Consult the code for this example on Github" href="https://github.com/Knowledge-Graphs-Book/examples/blob/main/Chapter_2_Data_Graphs/2_1_2_Heterogeneous_graphs/figure_2_2_b.cypher"></a></figcaption>
			</figure>
			<figcaption>Comparing directed edge-labelled graphs and heterogeneous graphs</figcaption>
		</figure>
		
		<div class="formal">
			<p>We next define the notion of a heterogeneous graph.</p>

			<dl class="definition" id="def-hg">
				<dt>Heterogeneous graph</dt>
				<dd>A <em>heterogeneous graph</em> is a tuple \(G = (V,E,L,l)\), where \(V \subseteq \con\) is a set of nodes, \(L \subseteq \con\) is a set of edge/node labels, \(E \subseteq V \times L \times V\) is a set of edges, and \(l : V \rightarrow L\) maps each node to a label.</dd>
			</dl>

			<div class="example">
				<p>In reference to Figure&nbsp;<? echo ref("fig:hg"); ?>, the set of nodes \(V\) has three elements: <code>Santiago</code>, <code>Chile</code>, and <code>Perú</code>. The set of edges \(E\) has 3 triples, including (<code>Santiago</code>, <code>capital</code>, <code>Chile</code>). The set of edge labels \(L\) has 4 elements: <code>capital</code>, <code>borders</code>, <code>City</code>, <code>Country</code>. Finally, with respect to the node labels, \(l(\)<code>Santiago</code>\() =\) <code>City</code>, \(l(\)<code>Chile</code>\() =\) <code>Country</code>, and \(l(\)<code>Perú</code>\() =\) <code>Country</code>.</p>
			</div>

			<p>In heterogeneous graphs, edge and node labels are often called <em>types</em>. By rather defining edges with labels as per directed edge-labelled graphs – rather than separately labelling edges with \(l\) – two nodes can be related by \(n\) edges with \(n\) different labels; for example, we can represent both \((\)<code>Santiago</code>, <code>capital</code>, <code>Chile</code>\()\) and \((\)<code>Santiago</code>, <code>country</code>, <code>Chile</code>\()\) as edges in the heterogeneous graph.</p>
		</div>

		<h4 id="sssec-propgraph" class="subsection">Property graphs</h4>
		<p>Property graphs constitute an alternative graph model that offers additional flexibility when modelling more complex relations. Consider integrating incoming data that provide further details on which companies offer fares on which flights, allowing the board to better understand available routes between cities (for example, on national airlines). In the case of directed edge-labelled graphs, we cannot directly annotate an edge like <? echo gedge("Santiago","flight","Arica"); ?> with the company (or companies) offering that route. But we could add a new node denoting a flight, connect it with the source, destination, companies, and mode, as shown in Figure&nbsp;<? echo ref("fig:fsa"); ?>. Applying this modelling to all routes in Figure&nbsp;<? echo ref("fig:delg"); ?> would, however, involve significant changes.</p>

		<p>The property graph model was thus proposed to offer additional flexibility when modelling data as a graph&nbsp;<? echo $references->cite("Miller13,AnglesABHRV17"); ?>. A property graph allows a set of <em>property–value</em> pairs and a <em>label</em> to be associated with both nodes and edges. Figure&nbsp;<? echo ref("fig:pg"); ?> depicts an example of a property graph with data analogous to Figure&nbsp;<? echo ref("fig:fsa"); ?>. We use property–value pairs on edges to model the companies. The type of relation is captured by the label <code>flight</code>. We further use node labels to indicate the types of the two nodes, and property–value pairs for their latitude and longitude.</p>

		<figure id="fig-flghts">
			<figure id="fig-fsa">
				<img src="images/fig-fsa.svg" alt="Directed edge-labelled graph"/>
				<figcaption>Directed edge-labelled graph <a class="git" title="Consult the code for this example on Github" href="https://github.com/Knowledge-Graphs-Book/examples/blob/main/Chapter_2_Data_Graphs/2_1_3_Property_graphs/figure_2_3_a.ttl"></a></figcaption>
			</figure>
			<figure id="fig-pg">
				<img src="images/fig-pg.svg" alt="Property graph"/>
				<figcaption>Property graph <a class="git" title="Consult the code for this example on Github" href="https://github.com/Knowledge-Graphs-Book/examples/blob/main/Chapter_2_Data_Graphs/2_1_3_Property_graphs/figure_2_3_b.cypher"></a></figcaption>
			</figure>
			<figcaption>Comparing directed edge-labelled graphs and property graphs</figcaption>
		</figure>

		<p>Property graphs are prominently used in graph databases, such as Neo4j&nbsp;<? echo $references->cite("Miller13,AnglesABHRV17"); ?>. Property graphs can be converted to/from directed edge-labelled graphs&nbsp;<? echo $references->cite("HernandezHK15,AnglesTT19"); ?> (per, e.g., Figure&nbsp;<? echo ref("fig:pg"); ?>). In summary, directed edge-labelled graphs offer a more minimal model, while property graphs offer a more flexible one. Often the choice of model will be secondary to other practical factors, such as the implementations available for different models, etc.</p>

		<div class="formal">
			<p>We formally define a property graph.</p>

			<dl class="definition" id="def-pg">
				<dt>Property graph</dt>
				<dd>A <em>property graph</em> is a tuple \(G = (V,E,L,P,U,e,l,p)\), where \(V \subseteq \con\) is a set of node ids, \(E \subseteq \con\) is a set of edge ids, \(L \subseteq \con\) is a set of labels, \(P \subseteq \con\) is a set of properties, \(U \subseteq \con\) is a set of values, \(e : E \rightarrow V \times V\) maps an edge id to a pair of node ids, \(l : V \cup E \rightarrow 2^L\) maps a node or edge id to a set of labels, and \(p : V \cup E \rightarrow 2^{P \times U}\) maps a node or edge id to a set of property–value pairs.</dd>
			</dl>

			<div class="example">
				<p>Returning to Figure&nbsp;<? echo ref("fig:pg"); ?>:</p>
				<ul>
					<li>the set \(V\) contains <code>Santiago</code> and <code>Arica</code>;</li>
					<li>the set \(E\) contains <code>LA380</code> and <code>LA381</code>;</li>
					<li>the set \(L\) contains <code>Capital City</code>, <code>Port City</code>, and <code>flight</code>;</li>
					<li>the set \(P\) contains <code>lat</code>, <code>long</code>, and <code>company</code>;</li>
					<li>the set \(U\) contains <code>–33.45</code>, <code>–70.66</code>, <code>LATAM</code>, <code>–18.48</code>, and <code>–70.33</code>;</li>
					<li>the mapping \(e\) gives, for example, \(e(\)<code>LA380</code>\() = (\)<code>Santiago</code>, <code>Arica</code>\()\);</li>
					<li>the mapping \(l\) gives, for example, \(l(\)<code>Santiago</code>\() =\{ \)<code>Capital City</code>\(\}\) and \(l(\)<code>LA380</code>\() =\)<span style="white-space:nowrap;">\(\{ \)<code>flight</code>\(\}\);</span></li>
					<li>the mapping \(p\) gives, for example, \(p(\)<code>LA380</code>\() =\{ (\)<code>company</code>, <code>LATAM</code>\() \}\) and \(p(\)<code>Santiago</code>\() =\)<span style="white-space:nowrap;">\(\{ (\)<code>lat</code>, <code>–33.45</code>\(), (\)<code>long</code>, <code>–70.66</code>\() \}\)</span>.</li>
				</ul>
			</div>

			<p>Unlike previous definitions&nbsp;<? echo $references->cite("AnglesABHRV17"); ?>, we allow a node or edge to have several values for a given property. In practice, systems like Neo4j&nbsp;<? echo $references->cite("Miller13"); ?> may rather support this by allowing a single array (i.e., list) of values.</p>
		</div>

		<h4 id="subsub-graphdataset" class="subsection">Graph dataset</h4>
		<p>Although multiple directed edge-labelled graphs can be merged by taking their union, it is often desirable to manage several graphs rather than one monolithic graph; for example, it may be beneficial to manage multiple graphs from different sources, making it possible to update or refine data from one source, to distinguish untrustworthy sources from more trustworthy ones, and so forth. A graph dataset then consists of a set of <em>named graphs</em> and a <em>default graph</em>. Each named graph is a pair of a graph ID and a graph. The default graph is a graph without an ID, and is referenced “by default” if a graph ID is not specified. Figure&nbsp;<? echo ref("fig:gd"); ?> provides an example where events and routes are stored in two named graphs, and the default graph manages metadata about the named graphs. Graph names can also be used as nodes in a graph. Furthermore, nodes and edges can be repeated across graphs, where the same node in different graphs will typically refer to the same entity, allowing data on that entity to be integrated when merging graphs. Though the example depicts a dataset of directed edge-labelled graphs, the concept generalises straightforwardly to datasets of other types of graphs.</p>

		<figure id="fig-gd">
			<img src="images/fig-gd.svg" alt="Graph dataset with two named graphs and a default graph describing events and routes"/>
			<figcaption>Graph dataset based on directed edge-labelled graphs with two named graphs and a default graph describing events and routes <a class="git" title="Consult the code for this example on Github" href="https://github.com/Knowledge-Graphs-Book/examples/blob/main/Chapter_2_Data_Graphs/2_1_4_Graph_dataset/figure_2_4.trig"></a></figcaption>
		</figure>

		<p>An RDF dataset is a graph dataset model standardised by the W3C&nbsp;<? echo $references->cite("rdf11"); ?> where each graph is an RDF graph, and graph names can be blank nodes or IRIs. A prominent use-case for RDF datasets is to manage and query <em>Linked Data</em> composed of interlinked documents of RDF graphs spanning the Web. When dealing with Web data, tracking the source of data becomes of key importance&nbsp;<? echo $references->cite("Dividino09,BonattiHPS11,zimm-etal-2012-JWS"); ?>. We will discuss Linked Data later in Section&nbsp;<? echo ref("sec:identity"); ?> and further discuss provenance in Section&nbsp;<? echo ref("ssec:knowledgeContext"); ?>.</p>

		<div class="formal">
			<p>We more formally define a graph dataset. We assume that all data graphs featured in a given graph dataset follow the same model (directed edge-labelled graph, heterogeneous graph, property graph, etc).</p>

			<dl class="definition" id="def-gd">
				<dt>Graph dataset</dt>
				<dd>A <em>named graph</em> is a pair \((n,G)\) where \(G\) is a data graph, and \(n \in \con\) is a graph name. A <em>graph dataset</em> is a pair \(D = (G_D,N)\) where \(G_D\) is a data graph called the <em>default graph</em> and \(N\) is either the empty set, or a set of named graphs \(\{ (n_1,G_1), \ldots (n_k,G_k) \}\) (\(k &gt; 0\)) such that if \(i \neq j\) then  \(n_i \neq n_j\) (for all \(1 \leq i \leq k\), \(1 \leq j \leq k\)).</dd>
			</dl>

			<div class="example">
				<p>Figure&nbsp;<? echo ref("fig:gd"); ?> provides an example of a directed edge-labelled graph dataset \(D\) consisting of two named graphs and a default graph. The default graph does not have a name associated with it. The two graph names are <code>Events</code> and <code>Routes</code>; these are also used as nodes in the default graph.</p>
			</div>
		</div>

		<h4 id="sssec-othergraphs" class="subsection">Other graph data models</h4>
		<p>The previous models are popular examples of graph representations. Other graph data models exist with <em>complex nodes</em> that may contain individual edges&nbsp;<? echo $references->cite("AnglesG08,Hartig14"); ?> or nested graphs&nbsp;<? echo $references->cite("AnglesG08,n3"); ?> (sometimes called <em>hypernodes</em>&nbsp;<? echo $references->cite("LeveneP89"); ?>. Likewise the mathematical notion of a <em>hypergraph</em> defines <em>complex edges</em> that connect sets rather than pairs of nodes. In our view, a knowledge graph can adopt any such graph data model based on nodes and edges: often data can be converted from one model to another (see Figure&nbsp;<? echo ref("fig:fsa"); ?> vs.&nbsp;Figure&nbsp;<? echo ref("fig:pg"); ?>). In the rest of the paper, we prefer discussing directed edge-labelled graphs given their relative succinctness, but most discussion extends naturally to other models.</p>

		<h4 id="sssec-graphstore" class="subsection">Graph stores</h4>
		<p>A variety of techniques have been proposed for storing and indexing graphs, facilitating the efficient evaluation of queries (as discussed next). Directed edge-labelled graphs can be stored in relational databases either as a single relation of arity three (<em>triple table</em>), as a binary relation for each property (<em>vertical partitioning</em>), or as \(n\)-ary relations for entities of a given type (<em>property tables</em>)&nbsp;<? echo $references->cite("WylotHCS18"); ?>. Custom (so-called <em>native</em>) storage techniques have also been developed for a variety of graph models, providing efficient access for finding nodes, edges and their adjacent elements&nbsp;<? echo $references->cite("AnglesG08,Miller13,WylotHCS18"); ?>. A number of systems further allow for distributing graphs over multiple machines based on popular NoSQL stores or custom partitioning schemes&nbsp;<? echo $references->cite("WylotHCS18,JankeS18"); ?>. For further details we refer to the book chapter by <? echo $references->citet("JankeS18"); ?> and the survey by <? echo $references->citet("WylotHCS18"); ?> dedicated to this topic.</p>
		</section>

		<section id="ssec-querying" class="section">
		<h3>Querying</h3>
		<p>A number of languages have been proposed for querying graphs&nbsp;<? echo $references->cite("AnglesABHRV17"); ?>, including the SPARQL query language for RDF graphs&nbsp;<? echo $references->cite("sparql11"); ?>; and Cypher&nbsp;<? echo $references->cite("FrancisGGLLMPRS18"); ?>, Gremlin&nbsp;<? echo $references->cite("Rodriguez15"); ?>, and G-CORE&nbsp;<? echo $references->cite("AnglesABBFGLPPS18"); ?> for querying property graphs. We refer to <? echo $references->citet("seifer19"); ?> for an investigation of the popularity of these languages. Underlying these query languages are some common primitives, including (basic) graph patterns, relational operators, path expressions, and more besides&nbsp;<? echo $references->cite("AnglesABHRV17"); ?>. We now describe these core features for querying graphs in turn, starting with basic graph patterns.</p>

		<h4 id="sssec-graphpatterns" class="subsection">Basic graph patterns</h4>
		<p>At the core of every structured query language for graphs lie <em>basic graph patterns</em>&nbsp;<? echo $references->cite("ConsensM90,AnglesABHRV17"); ?>, which follow the same model as the data graph being queried (see Section&nbsp;<? echo ref("ssec:graphModels"); ?>), additionally allowing variables as terms.<? echo footnote("The terms of a directed edge-labelled graph are its nodes and edge-labels. The terms of a property graph are its ids, labels, properties, and values (as used on either edges or nodes)."); ?> Terms in basic graph patterns are thus divided into constants, such as <span class="gnode">Arica</span> or <span class="gelab">venue</span>, and variables, which we prefix with question marks, such as <span class="gvar">?event</span> or <span class="gelab" style="color: black">?rel</span>. A basic graph pattern is then evaluated against the data graph by generating mappings from the variables of the graph pattern to constants in the data graph such that the image of the graph pattern under the mapping (replacing variables with the assigned constants) is contained within the data graph.</p>
		<p>Figure&nbsp;<? echo ref("fig:gp"); ?> provide an example of a basic graph pattern looking for the venues of Food Festivals, along with the possible mappings generated by the graph pattern against the data graph of Figure&nbsp;<? echo ref("fig:delg"); ?>. In some of the presented mappings (the last two listed), multiple variables are mapped to the same term, which may or may not be desirable depending on the application. Hence a number of semantics have been proposed for evaluating basic graph patterns&nbsp;<? echo $references->cite("AnglesABHRV17"); ?>, amongst which the most important are: <em>homomorphism-based semantics</em>, which allows multiple variables to be mapped to the same term such that all mappings shown in Figure&nbsp;<? echo ref("fig:gp"); ?> would be considered results; and <em>isomorphism-based semantics</em>, which requires variables on nodes and/or edges to be mapped to unique terms, thus excluding the latter three mappings of Figure&nbsp;<? echo ref("fig:gp"); ?> from the results. Different languages may adopt different semantics for evaluating basic graph patterns; for example, SPARQL adopts a homomorphism-based semantics, while Cypher adopts an isomorphism-based semantics specifically on edges (while allowing multiple variables to map to one node).</p>

		<figure id="fig-gp">
			<img src="images/fig-gp.svg" alt="Graph pattern" class="multi" />
			<div style="height:.5em;">&nbsp;</div>
			<table class="condensedTable">
				<thead>
					<tr>
						<th><span class="sf">?ev</span></th>
						<th><span class="sf">?vn1</span></th>
						<th><span class="sf">?vn2</span></th>
					</tr>
				</thead>
				<tbody>
					<tr>
						<td><code>EID16</code></td>
						<td><code>Piscina Olímpica</code></td>
						<td><code>Sotomayor</code></td>
					</tr>
					<tr>
						<td><code>EID16</code></td>
						<td><code>Sotomayor</code></td>
						<td><code>Piscina Olímpica</code></td>
					</tr>
					<tr>
						<td><code>EID16</code></td>
						<td><code>Piscina Olímpica</code></td>
						<td><code>Piscina Olímpica</code></td>
					</tr>
					<tr>
						<td><code>EID16</code></td>
						<td><code>Sotomayor</code></td>
						<td><code>Sotomayor</code></td>
					</tr>
					<tr>
						<td><code>EID15</code></td>
						<td><code>Santa Lucía</code></td>
						<td><code>Santa Lucía</code></td>
					</tr>
				</tbody>
			</table>
			<div style="height:.5em;">&nbsp;</div>
			<figcaption>basic directed edge-labelled graph pattern (left <a class="git" title="Consult the code for this example on Github" href="https://github.com/Knowledge-Graphs-Book/examples/blob/main/Chapter_2_Data_Graphs/2_2_1_Graph_patterns/figure_2_5.sparql"></a>) with mappings generated over the directed edge-labelled graph of Figure&nbsp;<? echo ref("fig:delg"); ?> (right)</figcaption>
		</figure>

		<p>As we will see in later examples (particularly Figure&nbsp;<? echo ref("fig:cgp"); ?>), basic graph patterns may also form cycles (be they directed or undirected), and may replace edge labels with variables. Basic graph patterns in the context of other models – such as property graphs – can be defined analogously by allowing variables to replace constants in any position of the model.</p>

		<div class="formal">
			<p>We formalise basic graph patterns first for directed edge-labelled graphs, and subsequently for property graphs&nbsp;<? echo $references->cite("AnglesABHRV17"); ?>. For these definitions, we introduce a countably infinite set of <em>variables</em> \(\var\) ranging over (but disjoint from: \(\con \cap \var = \emptyset\)) the set of constants. We refer generically to constants and variables as <em>terms</em>, denoted and defined as \(\term = \con \cup \var\). We define a basic graph pattern for a model by simply replacing constants with terms (that may be variables). Though we focus on directed edge-labelled graphs and property graphs, basic graph patterns for other graph models can be defined analogously.</p> 

			<dl class="definition" id="def-delgp">
				<dt>Basic directed edge-labelled graph pattern</dt>
				<dd>We define a <em>basic directed edge-labelled graph pattern</em> as a tuple \(Q = (V,E,L)\), where \(V \subseteq \term\) is a set of node terms, \(L \subseteq \term\) is a set of edge terms, and \(E \subseteq V \times L \times V\) is a set of edges (triple patterns).</dd>
			</dl>

			<div class="example">
				<p>Returning to the example of Figure&nbsp;<? echo ref("fig:gp"); ?>:</p>
				<ul>
					<li>the set \(V\) contains the constant <code>Food Festival</code> and variables <code>?event</code>, <code>?ven1</code> and <code>?ven2</code>;</li>
					<li>the set \(E\) contains four edges, including \((\)<code>?event</code>, <code>type</code>, <code>Food Festival</code>\()\);</li>
					<li>the set \(L\) contains the constants <code>type</code> and <code>venue</code>.</li>
				</ul>
			</div>

			<p>A basic property graph pattern is also defined by introducing variables.</p>

			<dl class="definition" id="def-pgp">
				<dt>Basic property graph pattern</dt>
				<dd>We define a <em>basic property graph pattern</em> as a tuple \(Q = (V,E,L,P,U,e,l,p)\), where \(V \subseteq \term\) is a set of node id terms, \(E \subseteq \term\) is a set of edge id terms, \(L \subseteq \term\) is a set of label terms, \(P \subseteq \term\) is a set of property terms, \(U \subseteq \term\) is a set of value terms, \(e : E \rightarrow V \times V\) maps an edge id term to a pair of node id terms, \(l : V \cup E \rightarrow 2^{L}\) maps a node or edge id term to a set of label terms, and \(p : V \cup E \rightarrow 2^{P \times U}\) maps a node or edge id term to a set of pairs of property–value terms.</dd>
			</dl>

			<p>Towards defining the results of evaluating a basic graph pattern over a data graph (following the same model), we first define a partial mapping \(\mu : \var \rightarrow \con\) from variables to constants, whose <em>domain</em> (the set of variables for which it is defined) is denoted by \(\dom(\mu)\). Given a basic graph pattern \(Q\), let \(\var(Q)\) denote the set of all variables appearing in (some recursively nested element of) \(Q\). We further denote by \(\mu(Q)\) the image of \(Q\) under \(\mu\), meaning that any variable \(v \in \var(Q) \cap \dom(\mu)\) is replaced in \(Q\) by \(\mu(v)\). Observe that when \(\var(Q) \subseteq \dom(\mu)\), then \(\mu(Q)\) is a data graph (in the corresponding model of \(Q\)).</p>
			<p>Next, we define the notion of containment between data graphs. For two directed edge-labelled graphs \(G_1 = (V_1,E_1,L_1)\) and \(G_2 = (V_2,E_2,L_2)\), we say that \(G_1\) is a <em>sub-graph</em> of \(G_2\), denoted \(G_1 \subseteq G_2\), if and only if \(V_1 \subseteq V_2\), \(E_1 \subseteq E_2\), and \(L_1 \subseteq L_2\).<? echo footnote("Given, for example, \\(G_1 = (\\{a\\},\\{(a,b,a)\\},\\{b,c\\})\\) and \\(G_2 = (\\{a,c\\},\\{(a,b,a)\\},\\{b\\})\\), we remark that \\(G_1 \\not\subseteq G_2\\) and \\(G_2 \\not\\subseteq G_1\\): the former has a label not used on an edge while the latter has a node without an incident edge. In concrete data models like RDF where such cases of nodes or labels without edges cannot occur, the sub-graph relation \\(G_1 \\subseteq G_2\\) holds if and only if \\(E_1 \\subseteq E_2\\) holds."); ?> Conversely, in property graphs, nodes can often be defined without edges. For two property graphs \(G_1 = (V_1,E_1,L_1,P_1,U_1,e_1,l_1,p_1)\) and \(G_2 = (V_2,E_2,L_2,P_2,U_2,e_2,l_2,p_2)\), we say that \(G_1\) is a <em>sub-graph</em> of \(G_2\), denoted \(G_1 \subseteq G_2\), if and only if \(V_1 \subseteq V_2\), \(E_1 \subseteq E_2\), \(L_1 \subseteq L_2\), \(P_1 \subseteq P_2\), \(U_1 \subseteq U_2\), for all \(x \in E_1\) it holds that \(e_1(x) = e_2(x)\), and for all \(y \in E_1 \cup V_1\) it holds that \(l_1(y) \subseteq l_2(y)\) and \(p_1(y) \subseteq p_2(y)\).</p>
			<p>We are now ready to define the evaluation of a basic graph pattern.</p>

			<dl class="definition" id="def-evgp">
				<dt>Evaluation of a basic graph pattern</dt>
				<dd>Let \(Q\) be a basic graph pattern and let \(G\) be a data graph (in the same model). We then define the <em>evaluation of the basic graph pattern \(Q\) over the data graph \(G\)</em>, denoted \(Q(G)\), to be the set of mappings \(Q(G) = \{ \mu \mid \mu(Q) \subseteq G \text{ and } \dom(\mu) = \var(Q) \}\).</dd>
			</dl>

			<div class="example">
				<p>Figure&nbsp;<? echo ref("fig:gp"); ?> enumerates all of the mappings given by the evaluation of the depicted basic graph pattern over the data graph of Figure&nbsp;<? echo ref("fig:delg"); ?>. Each non-header row indicates a mapping \(\mu\).</p>
			</div>

			<p>The final results of evaluating a basic graph pattern may vary depending on the choice of semantics: the results under <em>homomorphism-based semantics</em> are defined as \(Q(G)\). Conversely, under <em>isomorphism-based</em> semantics, mappings that send two edge variables to the same constant and/or mappings that send two node variables to the same constant may be excluded from the results. Henceforth we assume the more general <em>homomorphism-based semantics</em>.</p>
		</div>

		<h4 id="sssec-complexpatterns" class="subsection">Complex graph patterns</h4>
		<p>A (basic) graph pattern transforms an input graph into a table of results (as shown in Figure&nbsp;<? echo ref("fig:gp"); ?>). We may then consider using the relational algebra to combine and/or transform such tables, thus forming more complex queries from one or more graph patterns. Recall that the relational algebra consists of unary operators that accept one input table, and binary operators that accept two input tables. Unary operators include projection (\(\pi\)) to output a subset of columns, selection (\(\sigma\)) to output a subset of rows matching a given condition, and renaming of columns (\(\rho\)). Binary operators include union (\(\cup\)) to merge the rows of two tables into one table, difference (\(-\)) to remove the rows from the first table present in the second table, and joins (\(\Join\)) to extend the rows of one table with rows from the other table that satisfy a join condition. Selection and join conditions typically include equalities (\(=\)), inequalities (\(\leq\)), negation (\(\neg\)), disjunction (\(\vee\)), etc. From these operators, we can further define other (syntactic) operators, such as intersection (\(\cap\)) to output rows in both tables, anti-join (\(\rhd\), aka <em>minus</em>) to output rows from the first table for which there are no join-compatible rows in the second table, left-join (<? echo LeftJoin(); ?>, aka <em>optional</em>) to perform a join but keeping rows from the first table without a compatible row in the second table, etc.</p>
		<p>Basic graph patterns can then be expressed in a subset of relational algebra (namely \(\pi\), \(\sigma\), \(\rho\), \(\Join\)). Assuming, for example, a single ternary relation \(G(s,p,o)\) representing a graph – i.e., a table \(G\) with three columns \(s\), \(p\), \(o\) – the query of Figure&nbsp;<? echo ref("fig:gp"); ?> can be expressed in relational algebra as:</p>
		
		<p class="mathblock">\(\pi_{ev,vn_1,vn_2}(\sigma_{p=\texttt{type} \wedge o=\texttt{Food Festival} \wedge p_1=p_2=\texttt{venue}}(\rho_{s/ev}(G \bowtie \rho_{p/p_1,o/vn_1}(G) \bowtie \rho_{p/p_2,o/vn_2}(G))))\)</p>
		
		<p>where \(\Join\) denotes a <em>natural join</em>, meaning that equality is checked across pairs of columns with the same name in both tables (here, the join is thus performed on the subject column \(s\)). The result of this query is a table with a column for each variable: \(ev,vn1,vn2\). However, not all queries using \(\pi, \sigma, \rho\) and \(\Join\) on \(G\) can be expressed as basic graph patterns; for example, we cannot choose which variables to project in a basic graph pattern, but rather must project all variables not fixed to a constant.</p>
		<p>Graph query languages such as SPARQL&nbsp;<? echo $references->cite("sparql11"); ?> and Cypher&nbsp;<? echo $references->cite("FrancisGGLLMPRS18"); ?> allow the full use of relational operators over the results of graph patterns, giving rise to <em>complex graph patterns</em>&nbsp;<? echo $references->cite("AnglesABHRV17"); ?>. Figure&nbsp;<? echo ref("fig:cq"); ?> presents an example of a complex graph pattern with projected variables in bold, choosing particular variables to appear in the final results. In Figure&nbsp;<? echo ref("fig:cgp"); ?>, we give another example of a complex graph pattern looking for food festivals or drinks festivals not held in Santiago, optionally returning their start date and name (where available).</p>

		<figure id="fig-cq">
			<img src="images/fig-cq.svg" alt="Conjunctive query" class="multi" />
			<table class="condensedTable">
				<thead>
					<tr>
						<th><span class="sf">?name1</span></th>
						<th><span class="sf">?con</span></th>
						<th><span class="sf">?name2</span></th>
					</tr>
				</thead>
				<tbody>
					<tr>
						<td><code>Food Truck</code></td>
						<td><code>bus</code></td>
						<td><code>Food Truck</code></td>
					</tr>
					<tr>
						<td><code>Food Truck</code></td>
						<td><code>bus</code></td>
						<td><code>Food Truck</code></td>
					</tr>
					<tr>
						<td><code>Food Truck</code></td>
						<td><code>bus</code></td>
						<td><code>Ñam</code></td>
					</tr>
					<tr>
						<td><code>Food Truck</code></td>
						<td><code>flight</code></td>
						<td><code>Ñam</code></td>
					</tr>
					<tr>
						<td><code>Food Truck</code></td>
						<td><code>flight</code></td>
						<td><code>Ñam</code></td>
					</tr>
					<tr>
						<td><code>Ñam</code></td>
						<td><code>bus</code></td>
						<td><code>Food Truck</code></td>
					</tr>
					<tr>
						<td><code>Ñam</code></td>
						<td><code>flight</code></td>
						<td><code>Food Truck</code></td>
					</tr>
					<tr>
						<td><code>Ñam</code></td>
						<td><code>flight</code></td>
						<td><code>Food Truck</code></td>
					</tr>
				</tbody>
			</table>
			<figcaption>Complex graph pattern (left <a class="git" title="Consult the code for this example on Github" href="https://github.com/Knowledge-Graphs-Book/examples/blob/main/Chapter_2_Data_Graphs/2_2_2_Complex_graph_patterns/figure_2_6.sparql"></a>) with mappings generated over the graph of Figure&nbsp;<? echo ref("fig:delg"); ?> (right)</figcaption>
		</figure>

		<p>Complex graph patterns can give rise to duplicate results; for example, the first result in Figure&nbsp;<? echo ref("fig:cq"); ?> appears twice since <code>?city1</code> matches <code>Arica</code> and <code>?city2</code> matches <code>Viña del Mar</code> in one result, and vice-versa in the other. Query languages then offer two semantics: <em>bag semantics</em> preserves duplicates according to the multiplicity of the underlying mappings, while <em>set semantics</em> (typically invoked with a <code>DISTINCT</code> keyword) removes duplicates from the results.</p>

		<figure id="fig-cgp">
			<img class="inlined" src="images/fig-cgp1.svg" alt="Complex graph pattern 1"/>
			<img class="inlined" src="images/fig-cgp2.svg" alt="Complex graph pattern 2"/>
			<img class="inlined" src="images/fig-cgp3.svg" alt="Complex graph pattern 3"/>
			<img class="inlined" src="images/fig-cgp4.svg" alt="Complex graph pattern 4"/>
			<img class="inlined" src="images/fig-cgp5.svg" alt="Complex graph pattern 5"/>
			<div><div style="display:inline;">\(Q := ((((Q_1 \cup Q_2) \rhd Q_3)\) <? echo LeftJoin() ?> \(Q_4 )\) <? echo LeftJoin() ?> \(Q_5),\qquad Q(G) =\) <table class="condensedTable" style="position:relative;top:.6em;display:inline-block;vertical-align:middle;"><thead><tr><th>?event</th><th>?start</th><th>?name</th></tr></thead><tbody><tr><td><code>EID16</code></td><td></td><td><code>Food Truck</code></td></tr></tbody></table></div></div>
			<figcaption>Complex graph pattern (\(Q\)) with mappings generated (\(Q(G)\)) over the graph of Figure&nbsp;<? echo ref("fig:delg"); ?> (\(G\)) <a class="git" title="Consult the code for this example on Github" href="https://github.com/Knowledge-Graphs-Book/examples/blob/main/Chapter_2_Data_Graphs/2_2_2_Complex_graph_patterns/figure_2_7.sparql"></a></figcaption>
		</figure>

		<div class="formal">
			<p>We now formally define complex graph patterns.</p>

			<dl class="definition" id="def-cgp">
				<dt>Complex graph pattern</dt>
				<dd><em>Complex graph patterns</em> are defined recursively, as follows:
					<ul>
						<li>If \(Q\) is a basic graph pattern, then \(Q\) is a <em>complex graph pattern</em>.</li>
						<li>If \(Q\) is a complex graph pattern, and \(\mathcal{V} \subseteq \var(Q)\), then \(\pi_\mathcal{V}(Q)\) is a <em>complex graph pattern</em>.</li>
						<li>If \(Q\) is a complex graph pattern, and \(R\) is a selection condition with Boolean and equality connectives (\(\wedge\), \(\vee\), \(\neg\), \(=\)), then \(\sigma_R(Q)\) is a <em>complex graph pattern</em>.</li>
						<li>If both \(Q_1\) and \(Q_2\) are complex graph patterns, then \(Q_1 \Join Q_2\), \(Q_1 \cup Q_2\), \(Q_1 - Q_2\) and \(Q_1 \rhd Q_2\) are also <em>complex graph patterns</em>.</li>
					</ul>
				</dd>
			</dl>

			<p>We now define the evaluation of complex graph patterns. Given a mapping \(\mu\), for a set of variables \(\mathcal{V} \subseteq \var\) let \(\mu[\mathcal{V}]\) denote the mapping \(\mu'\) such that \(\dom(\mu') = \dom(\mu) \cap \mathcal{V}\) and \(\mu'(v) = \mu(v)\) for all \(v \in \dom(\mu')\) (in other words, \(\mu[\mathcal{V}]\) projects the variables \(\mathcal{V}\) from \(\mu\)). Letting \(R\) denote a Boolean selection condition and \(\mu\) a mapping, we denote by \(\mu \models R\) that \(\mu\) satisfies the Boolean condition. Finally, we define two mappings \(\mu_1\) and \(\mu_2\) to be <em>compatible</em>, denoted \(\mu_1 \sim \mu_2\), if and only if \(\mu_1(v) = \mu_2(v)\) for all \(v \in \dom(\mu_1) \cap \dom(\mu_2)\) (i.e., they map common variables to the same constant). We are now ready to provide the definition.</p>

			<dl class="definition" id="def-evalcgp">
				<dt>Complex graph pattern evaluation</dt>
				<dd>Given a complex graph pattern \(Q\), if \(Q\) is a basic graph pattern, then \(Q(G)\) is defined per Definition&nbsp;<? echo ref("def:evgp"); ?>. Otherwise, \(Q(G)\) is defined as follows:
				\begin{align*}
					\pi_\mathcal{V}(Q)(G) = & \,\{ \mu[\mathcal{V}] \mid \mu \in Q(G) \} \\
					\sigma_R(Q)(G) = & \, \{ \mu \mid \mu \in Q(G)\text{ and }\mu \models R\}\\
					Q_1 \Join Q_2(G) = & \,\{ \mu_1 \cup \mu_2 \mid \mu_1 \in Q_2(G), \mu_2 \in Q_1(G)\text{ and }\mu_1 \sim \mu_2 \} \\
					Q_1 \cup Q_2(G) = & \,\{ \mu \mid \mu \in Q_1(G)\text{ or } \mu \in Q_2(G) \} \\
					Q_1 - Q_2(G) = & \,\{ \mu \mid \mu \in Q_1(G)\text{ and } \mu \notin Q_2(G) \} \\
					Q_1 \rhd Q_2(G) = & \,\{ \mu \mid \mu \in Q_1(G)\text{ and }\nexists \mu_2 \in Q_2(G)\text{ such that }\mu \sim \mu_2 \}
				\end{align*}</dd>
			</dl>

			<p>Based on these operators, we can define some additional syntactic operators, such as the <em>left-join</em> (<? echo LeftJoin(); ?>, aka <em>optional</em>):</p>
			<p>
			\begin{align*}
			 Q_1 <? echo LeftJoin(false); ?> Q_2(G) = & \,(Q_1(G) \Join Q_2(G)) \cup (Q_1(G) \rhd Q_2(G))
			\end{align*}
			</p>
			<p>We call such operators <em>syntactic</em> as they do not add expressivity.</p>

			<div class="example">
				<p>Figure&nbsp;<? echo ref("fig:cgp"); ?> illustrates a complex graph pattern and its evaluation.</p>
			</div>
		</div>

		<h4 id="sssec-navpatterns" class="subsection">Navigational graph patterns</h4>
		<p>A key feature that distinguishes graph query languages is the ability to include <em>path expressions</em> in queries. A path expression \(r\) is a regular expression that allows for matching arbitrary-length paths between two nodes using a <em>regular path query</em> \((x,r,y)\), where \(x\) and \(y\) can be variables or constants (or even the same term). The base path expression is where \(r\) is a constant (an edge label). Furthermore if \(r\) is a path expression, then \(r^*\) (<em>Kleene star</em>: zero-or-more) is also a path expression. Finally, if \(r_1\) and \(r_2\) are path expressions, then \(r_1 \mid r_2\) (<em>disjunction</em>) and \(r_1 \cdot r_2\) (<em>concatenation</em>) are also path expressions. A related notion is that of <em>2-way regular path queries</em>, which also allow for querying inverse paths; specifically, if \(r\) is path expression, then it is a <em>2-way path expression</em>, and if \(r\) is a <em>2-way path expression</em>, then \(r^-\) (<em>inverse</em>) is a <em>2-way path expression</em>. Henceforth we will refer generically to both the 1-way and 2-way variants as path expressions and regular path queries.</p>
		<p>Regular path queries can be evaluated under a number of different semantics. For example, \((\)<code>Arica</code>, <code>bus*</code>, <code>?city</code>\()\) evaluated against the graph of Figure&nbsp;<? echo ref("fig:delg"); ?> may match the paths shown in Figure&nbsp;<? echo ref("fig:path"); ?>. In fact, since a cycle is present, an infinite number of paths are potentially matched. For this reason, restricted semantics are often applied, returning only the shortest paths, or paths without repeated nodes or edges (as in the case of Cypher).<? echo footnote("Mapping variables to paths requires special treatment&nbsp;". $references->cite("AnglesABHRV17") .". Cypher&nbsp;". $references->cite("FrancisGGLLMPRS18") ." returns a string that encodes a path, upon which certain functions such as <code>length(·)</code> can be applied. G-CORE&nbsp;". $references->cite("AnglesABBFGLPPS18") .", on the other hand, allows for returning paths, and supports additional operators on them, including projecting them as graphs, applying cost functions, and more besides."); ?> Rather than returning paths, another option is to instead return the (finite) set of pairs of nodes connected by a matching path (as in the case of SPARQL&nbsp;1.1).</p>

		<figure id="fig-path">
			<img class="inlined" src="images/fig-path1.svg" alt="Path matching 1"/>
			<img class="inlined" src="images/fig-path2.svg" alt="Path matching 2"/>
			<img class="inlined" src="images/fig-path3.svg" alt="Path matching 3"/>
			<img class="inlined" src="images/fig-path4.svg" alt="Path matching 4"/>
			<span style="margin-left:2em;">⋯</span>
			<figcaption>Example paths matching \((\)<code>Arica</code>, <code>bus*</code>, <code>?city</code>\()\) over the graph of Figure&nbsp;<? echo ref("fig:delg"); ?></figcaption>
		</figure>

		<p>Regular path queries can then be used in basic graph patterns to express <em>navigational graph patterns</em>&nbsp;<? echo $references->cite("AnglesABHRV17"); ?>, as shown in Figure&nbsp;<? echo ref("fig:ngp"); ?>, which illustrates a query searching for food festivals in cities reachable (recursively) from Arica by bus or flight. Furthermore, when regular path queries and graph patterns are combined with operators such as projection, selection, union, difference, and optional, the result is known as <em>complex navigational graph patterns</em>&nbsp;<? echo $references->cite("AnglesABHRV17"); ?>.</p>

		<figure id="fig-ngp">
			<img src="images/fig-ngp.svg" alt="Navigational graph pattern" class="multi" />
			<div style="height:2em;">&nbsp;</div>
			<table class="condensedTable">
				<thead>
					<tr>
						<th><span class="sf">?event</span></th>
						<th><span class="sf">?name</span></th>
						<th><span class="sf">?city</span></th>
					</tr>
				</thead>
				<tbody>
					<tr>
						<td><code>EID15</code></td>
						<td><code>Ñam</code></td>
						<td><code>Santiago</code></td>
					</tr>
					<tr>
						<td><code>EID16</code></td>
						<td><code>Food Truck</code></td>
						<td><code>Arica</code></td>
					</tr>
					<tr>
						<td><code>EID16</code></td>
						<td><code>Food Truck</code></td>
						<td><code>Viña del Mar</code></td>
					</tr>
				</tbody>
			</table>
			<div style="height:1em;">&nbsp;</div>
			<figcaption>Navigational graph pattern (left <a class="git" title="Consult the code for this example on Github" href="https://github.com/Knowledge-Graphs-Book/examples/blob/main/Chapter_2_Data_Graphs/2_2_3_Navigational_graph_patterns/figure_2_9.sparql"></a>) with mappings generated over the graph of Figure&nbsp;<? echo ref("fig:delg"); ?> (right)</figcaption>
		</figure>

		<div class="formal">
			<p>We first define path expressions and regular path queries.</p>

			<dl class="definition" id="def-path-expression">
				<dt>Path expression</dt>
				<dd>A constant (edge label) \(c\) is a <em>path expression</em>. Furthermore, if \(r\), \(r_1\) and \(r_2\) are path expressions, then:
					<ul>
						<li>\(r^-\) (<em>inverse</em>) and \(r^*\) (<em>Kleene star</em>) are <em>path expressions</em>.</li>
						<li>\(r_1 \cdot r_2\) (<em>concatenation</em>) and \(r_1 \mid r_2\) (<em>disjunction</em>) are <em>path expressions</em>.</li>
					</ul>
				</dd>
			</dl>
		
			<p>We now define the evaluation of a path expression on a directed-edge labelled graph under the SPARQL 1.1-style semantics whereby the endpoints (pairs of start and end nodes) of the path are returned&nbsp;<? echo $references->cite("sparql11"); ?>.</p>

			<dl class="definition" id="def-path-expression-evaluation">
				<dt>Path evaluation (directed edge-labelled graph)</dt>
				<dd>Given a directed edge-labelled graph \(G = (V,E,L)\) and a path expression \(r\), we define the <em>evaluation of \(r\) over \(G\)</em>, denoted \(r[G]\), as follows:
				\begin{align*}
				r[G] = &\, \{ (u,v) \mid (u,r,v) \in E \} \,(\text{for }r \in \con) \\
				r^-[G] = &\, \{ (u,v) \mid (v,u) \in r[G] \} \\
				r_1 \mid r_2[G] = &\, r_1[G] \cup r_2[G] \\
				r_1 \cdot r_2[G] = &\, \{ (u,v) \mid \exists w \in V : (u,w) \in r_1[G]\text{ and }(w,v) \in r_2[G]\}\\
				r^*[G] = &\, V \cup \bigcup_{n \in \mathbb{N^+}} r^n[G]
				\end{align*}
				where by \(r^n\) we denote the \(n\)<sup>th</sup>-concatenation of \(r\) (e.g., \(r^3 = r \cdot r \cdot r\)).</dd>
			</dl>

			<p>The evaluation of a path expression on a property graph \(G = (V,E,L,P,U,e,l,p)\) can be defined analogously by adapting the first definition (in the case that \(r \in \con\)) as follows:</p>
			<p>\[ r[G] = \{(u,v) \mid \exists x \in E : e(x) = (u,v)\text{ and }l(e) = r \} \,.\]</p>
			<p>The rest of the definitions then remain unchanged.</p>
			<p>Query languages may support additional operators, some of which are syntactic (e.g., \(r^+\) is sometimes used for one-or-more, but can be rewritten as \(r \cdot r^*\)), while others may add expressivity such as the case of SPARQL&nbsp;<? echo $references->cite("sparql11"); ?>, which allows a limited form of negation in expressions (e.g., \(!r\), with \(r\) being a constant or the inverse of a constant, matching any path not labelled \(r\)).</p>
			<p>Next we define a regular path query and its evaluation.</p>

			<dl class="definition" id="def-regular-path-query">
				<dt>Regular path query</dt>
				<dd>A <em>regular path query</em> is a triple \((x,r,y)\) where \(x,y \in \con \cup \var\) and \(r\) is a path expression.</dd>
			</dl>

			<dl class="definition" id="def-regular-path-query-evaluation">
				<dt>Regular path query evaluation</dt>
				<dd>Let \(G\) denote a directed edge-labelled graph, \(c\), \(c_1\), \(c_2 \in \con\) denote constants and \(z\), \(z_1\), \(z_2 \in \var\) denote variables. Then the <em>evaluation of a regular path query</em> is defined as follows:
				\begin{align*}
				(c_1,r,c_2)(G) = & \{ \mu_\emptyset \mid (c_1,c_2) \in r[G] \} \\
				(c,r,z)(G) = & \{ \mu \mid \dom(\mu) = \{ z \}\text{ and }(c,\mu(z)) \in r[G] \} \\
				(z,r,c)(G) = & \{ \mu \mid \dom(\mu) = \{ z \}\text{ and }(\mu(z),c) \in r[G] \} \\
				(z_1,r,z_2)(G) = & \{ \mu \mid \dom(\mu) = \{ z_1, z_2 \}\text{ and }(\mu(z_1),\mu(z_2)) \in r[G] \}
				\end{align*}
				where \(\mu_\emptyset\) denotes the empty mapping such that \(\dom(\mu) = \emptyset\) (the join identity).</dd>
			</dl>

			<dl class="definition" id="def-navigational-graph-pattern">
				<dt>Navigational graph pattern</dt>
				<dd>If \(Q\) is a basic graph pattern, then \(Q\) is a <em>navigational graph pattern</em>. If \(Q\) is a navigational graph pattern and \((x,r,y)\) is a regular path query, then \(Q \Join (x,r,y)\) is a <em>navigational graph pattern</em>.</dd>
			</dl>

			<p>The definition of the evaluation of a navigational graph pattern then follows from the previous definition of a join and the definition of the evaluation of a regular path query (for a directed edge-labelled graph or a property graph, respectively). Likewise, <em>complex navigational graph patterns</em> – and their evaluation – are defined by extending this definition in the natural way with the same operators from Definition&nbsp;<? echo ref("def:cgp"); ?> following the same semantics seen in Definition&nbsp;<? echo ref("def:evalcgp"); ?>.</p>
		</div>

		<h4 id="app-qother" class="subsection">Other features</h4>
		<p>Thus far, we have discussed features that form the practical and theoretical foundation of any query language for graphs&nbsp;<? echo $references->cite("AnglesABHRV17"); ?>. However, specific query languages for graphs may support other features, such as aggregation (<code>GROUP BY</code>, <code>COUNT</code>, etc.), more complex filters and datatype operators (e.g., range queries on years extracted from a date), federation for querying remotely hosted graphs over the Web, languages for updating graphs, support for entailment, etc. For more information, we refer to the documentation of the respective query languages (e.g.,&nbsp;<? echo $references->cite("sparql11,AnglesABBFGLPPS18"); ?>) and to the survey by&nbsp;<? echo $references->citet("AnglesABHRV17"); ?>.</p>

		<h4 id="app-quis" class="subsection">Query Interfaces</h4>
		<p>Knowledge graphs are often queried by non-expert users who may not be able to express their information needs in terms of a particular graph query language. Different types of interfaces have thus been proposed in order to assist users in querying data graphs. Such interfaces may support, for example:</p>

		<dl>
			<dt>Faceted browsing:</dt>
			<dd>Users start by specifying a simple search, such as a keyword search, a type of node like <code>Food Festival</code>, or possibly other kinds of search. They are then presented with a set of matching results, and a set of facets, which are typically attributes (e.g., <code>venue</code>) and values (e.g., <code>Santa Lucía</code>) present in the current results set. Selecting a value for a facet restricts the current results set to include only results with the indicated value; this selection process can be applied iteratively to restrict results per multiple facets. Often the faceted criteria are translated into and evaluated as graph queries. Though relatively intuitive for users, such systems typically support acyclic queries that generate lists of results (analogous to graph queries that project a single variable), and rarely support more expressive queries. Examples of faceted browsing systems for graphs include VisiNav&nbsp;<? echo $references->cite("Harth10"); ?>, Broccoli&nbsp;<? echo $references->cite("BastB13"); ?>, SemFacet&nbsp;<? echo $references->cite("ArenasGKMZ16"); ?>, GraFa&nbsp;<? echo $references->cite("Moreno-VegaH18"); ?>, etc.</dd>
			<dt>Query building:</dt>
			<dd>Users are provided with a form or graphical interface that can be used to specify a graph query without needing to understand the syntax of a specific query language. Such query builders allow for incrementally adding nodes or edges to the query, assisted by features such as auto-completion, previewing intermediate results, and graph navigation. Query builders typically allow for expressing queries equivalent to (cyclic) basic graph patterns, but may not support more expressive features of query languages as described herein. Graph query builder systems include Smeagol&nbsp;<? echo $references->cite("ClemmerD11"); ?>, QueryVOWL&nbsp;<? echo $references->cite("HaagLSE15a"); ?>, VIIQ&nbsp;<? echo $references->cite("JayaramGL15"); ?>, Sparklis&nbsp;<? echo $references->cite("Ferre17"); ?>, RDF Explorer&nbsp;<? echo $references->cite("VargasAHL19"); ?>, and more besides.</dd>
			<dt>Query-by-example:</dt>
			<dd>Users provide examples of positive and sometimes negative answers to their queries. For example, they may provide as positive examples the nodes <span class="gnode">Arica</span>, <span class="gnode">Santiago</span>, <span class="gnode">Viña del Mar</span>, and as negative examples the nodes <span class="gnode">Chile</span>, <span class="gnode">Lima</span>, where the system will then “reverse engineer” a query that returns positive examples but not negative examples (in this case, the query proposed may return nodes of type <code>City</code> whose <code>country</code> is <code>Chile</code>). Query-by-example systems typically support basic graph patterns, and may not support more expressive querying features. They are useful in cases where users have examples of what they are looking for, but are not necessarily sure of the query they need to retrieve similar examples. Query-by-example systems for graphs include GQBE&nbsp;<? echo $references->cite("JayaramKLYE15"); ?> and SPARQLByE&nbsp;<? echo $references->cite("DiazAB16"); ?>.</dd>
			<dt>Question answering:</dt>
			<dd>Users express their queries as questions in natural language; for example, they might ask “<em>What food festivals will be held in Arica?</em>”. The question answering system will then generate answers from the graph based on its best interpretation of the question. We identify three types of question answering system. <em>Navigation-based systems</em> identify entities/nodes from the graph that are mentioned in the query, and then attempt to navigate edges from those nodes whose labels best match the question; for example, they may match the nodes <span class="gnode">Food Festival</span> and <span class="gnode">Arica</span> in the graph based on the question, and from there, try to navigate edges in the graph whose labels match the question in order to find answers. <em>Template-based systems</em> rather pre-suppose a fixed list of question templates expressed in the query language, with placeholder variables that will be replaced with entities/nodes detected in the question; a template matched for the previous example may be of the form “<em>What <code>X</code> will be held in <code>Y</code>?</em>”. <em>Translation-based systems</em> attempt to translate the question into a query in the structured query language, using (typically neural) machine translation techniques. The latter two types of question answering systems can additionally return a graph query that explains the answers generated. Question answering systems are often very intuitive to use, but may not always return correct results, particularly when considering complex questions/queries. Examples of question answering systems for knowledge graphs include Treo&nbsp;<? echo $references->cite("FreitasOOCS11a"); ?>, NFF&nbsp;<? echo $references->cite("Hu0YWZ18"); ?>, TemplateQA&nbsp;<? echo $references->cite("ZhengYZC18"); ?>, WDAqua-core1&nbsp;<? echo $references->cite("DiefenbachBSM20"); ?>, and more besides.</dd>
		</dl>

		<p>Such query interfaces enable non-expert users to formulate queries over graphs, which in turn broadens the potential impact of knowledge graphs.</p>
		</section>
	</section>
