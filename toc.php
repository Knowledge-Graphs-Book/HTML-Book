	<nav id="toc">
		<div><p>Table of Contents</p></div>
		<ol>
			<li><a href="#sec-preface">Preface</a></li>
			<li><a href="#sec-ack">Acknowledgements</a></li>
			<li><a href="#chap-intro">1. Introduction</a></li>
			<li><a href="#chap-graph">2. Data Graphs</a>
			<ol>
				<li><a href="#ssec-graphModels">2.1. Models</a>
				<ol>
					<li><a href="#sssec-directedelg">2.1.1 Directed edge-labelled graphs</a></li>
					<li><a href="#subsub-heterograph">2.1.2 Heterogeneous graphs</a></li>
					<li><a href="#sssec-propgraph">2.1.3 Property graphs</a></li>
					<li><a href="#subsub-graphdataset">2.1.4 Graph dataset</a></li>
					<li><a href="#sssec-othergraphs">2.1.5 Other graph data models</a></li>
					<li><a href="#sssec-graphstore">2.1.6 Graph stores</a></li>
				</ol></li>
				<li><a href="#ssec-querying">2.2. Querying</a>
				<ol>
					<li><a href="#sssec-graphpatterns">2.2.1 Basic graph patterns</a></li>
					<li><a href="#sssec-complexpatterns">2.2.2 Complex graph patterns</a></li>
					<li><a href="#sssec-navpatterns">2.2.3 Navigational graph patterns</a></li>
					<li><a href="#app-qother">2.2.4 Other features</a></li>
					<li><a href="#app-quis">2.2.5 Query Interfaces</a></li>
				</ol></li>
			</ol></li>
			<li><a href="#chap-knowledge">3. Schema, Identity, Context</a>
			<ol>
				<li><a href="#sec-schema">3.1. Schema</a>
				<ol>
					<li><a href="#sec-semSchema">3.1.1 Semantic schema</a></li>
					<li><a href="#sssec-validating-schema">3.1.2 Validating schema</a></li>
					<li><a href="#ssec-emergentSchema">3.1.3 Emergent schema</a></li>
				</ol></li>
				<li><a href="#sec-identity">3.2. Identity</a>
				<ol>
					<li><a href="#subsec-globalIdentifiers">3.2.1 Persistent identifiers</a></li>
					<li><a href="#sssec-external_identy">3.2.2 External identity links</a></li>
					<li><a href="#sssec-datatypes">3.2.3 Datatypes</a></li>
					<li><a href="#sssec-lexicalisation">3.2.4 Lexicalisation</a></li>
					<li><a href="#sssec-existential">3.2.5 Existential nodes</a></li>
				</ol></li>
				<li><a href="#ssec-knowledgeContext">3.3. Context</a>
				<ol>
					<li><a href="#sssec-direct-representation">3.3.1 Direct representation</a></li>
					<li><a href="#sec-reify">3.3.2 Reification</a></li>
					<li><a href="#sssec-higher-arity">3.3.3 Higher-arity representation</a></li>
					<li><a href="#sssec-annotations">3.3.4 Annotations</a></li>
					<li><a href="#sssec-other-context">3.3.5 Other contextual frameworks</a></li>
				</ol></li>
			</ol></li>
			<li><a href="#chap-deductive">4. Deductive Knowledge</a>
			<ol>
				<li><a href="#ssec-ontologies">4.1. Ontologies</a>
				<ol>
					<li><a href="#sssec-interpretations">4.1.1 Interpretations and models</a></li>
					<li><a href="#ssec-ontology-features">4.1.2 Ontology features</a></li>
					<li><a href="#sec-ontSemantics">4.1.3 Entailment</a></li>
					<li><a href="#sec-iff">4.1.4 If–then vs. if-and-only-if semantics</a></li>
				</ol></li>
				<li><a href="#ssec-reasoning">4.2. Reasoning</a>
				<ol>
					<li><a href="#sec-rules">4.2.1 Rules</a></li>
					<li><a href="#sssec-dls">4.2.2 Description Logics</a></li>
				</ol></li>
			</ol></li>
			<li><a href="#chap-inductive">5. Inductive Knowledge</a>
			<ol>
				<li><a href="#sec-gAnalytics">5.1. Graph Analytics</a>
				<ol>
					<li><a href="#sssec-graph-analytics-tasks">5.1.1 Techniques</a></li>
					<li><a href="#sssec-technologies-graph-analytics">5.1.2 Frameworks</a></li>
					<li><a href="#sssec-query-languages">5.1.3 Analytics on data graphs</a></li>
					<li><a href="#sssec-analyticsQ">5.1.4 Analytics with queries</a></li>
					<li><a href="#sssec-analyticsE">5.1.5 Analytics with entailment</a></li>
				</ol></li>
				<li><a href="#ssec-embeddings">5.2. Knowledge Graph Embeddings</a>
				<ol>
					<li><a href="#ssec-tensor-based-models">5.2.1 Tensor-based models</a></li>
					<li><a href="#sssec-language-models">5.2.2 Language models</a></li>
					<li><a href="#sssec-entailment-aware-models">5.2.3 Entailment-aware models</a></li>
				</ol></li>
				<li><a href="#ssec-gnns">5.3. Graph Neural Networks</a>
				<ol>
					<li><a href="#sssec-recursive-gnn">5.3.1 Recursive graph neural networks</a></li>
					<li><a href="#sssec-convolutional-gnn">5.3.2 Non-recursive graph neural networks</a></li>
				</ol></li>
				<li><a href="#ssec-symlearn">5.4. Symbolic Learning</a>
				<ol>
					<li><a href="#sssec-rule-mining">5.4.1 Rule mining</a></li>
					<li><a href="#sssec-axiom-mining">5.4.2 Axiom mining</a></li>
					<li><a href="#sssec-hypothesis-mining">5.4.3 Hypothesis mining</a></li>
				</ol></li>
			</ol></li>
			<li><a href="#chap-create">6. Creation and Enrichment</a>
			<ol>
				<li><a href="#sssec-graphCreationHuman">6.1. Human Collaboration</a></li>
				<li><a href="#sssec-graphCreationText">6.2. Text Sources</a>
				<ol>
					<li><a href="#sssec-pre-processing">6.2.1 Pre-processing</a></li>
					<li><a href="#sssec-ner">6.2.2 Named Entity Recognition (NER)</a></li>
					<li><a href="#sssec-el">6.2.3 Entity Linking (EL)</a></li>
					<li><a href="#sssec-er">6.2.4 Relation Extraction (RE)</a></li>
					<li><a href="#sssec-joint-tasks">6.2.5 Joint tasks</a></li>
				</ol></li>
				<li><a href="#sssec-graphCreationSemistructured">6.3. Markup Sources</a>
				<ol>
					<li><a href="#sssec-wrapper-based-extraction">6.3.1 Wrapper-based extraction</a></li>
					<li><a href="#sssec-web-table-extraction">6.3.2 Web table extraction</a></li>
					<li><a href="#sssec-deep-web-crawling">6.3.3 Deep Web crawling</a></li>
				</ol></li>
				<li><a href="#sssec-graphCreationStructured">6.4. Structured Sources</a>
				<ol>
					<li><a href="#sssec-mapping-from-tables">6.4.1 Mapping from tables</a></li>
					<li><a href="#sssec-mapping-from-trees">6.4.2 Mapping from trees</a></li>
					<li><a href="#sssec-mapping-from-other">6.4.3 Mapping from other knowledge graphs</a></li>
				</ol></li>
				<li><a href="#ssec-knowledgeConceptual">6.5. Schema/Ontology Creation</a>
				<ol>
					<li><a href="#sssec-ontology-engineering">6.5.1 Ontology engineering</a></li>
					<li><a href="#sssec-ontology-learning">6.5.2 Ontology learning</a></li>
				</ol></li>
			</ol></li>
			<li><a href="#chap-quality">7. Quality Assessment</a>
			<ol>
				<li><a href="#ssec-accuracy">7.1. Accuracy</a>
				<ol>
					<li><a href="#sssec-syntactic-accuracy">7.1.1 Syntactic accuracy</a></li>
					<li><a href="#sssec-semantic-accuracy">7.1.2 Semantic accuracy</a></li>
					<li><a href="#sssec-timeliness">7.1.3 Timeliness</a></li>
				</ol></li>
				<li><a href="#sssec-coverage">7.2. Coverage</a>
				<ol>
					<li><a href="#sssec-completeness">7.2.1 Completeness</a></li>
					<li><a href="#sssec-representativeness">7.2.2 Representativeness</a></li>
				</ol></li>
				<li><a href="#ssec-coherency">7.3. Coherency</a>
				<ol>
					<li><a href="#sssec-consistency">7.3.1 Consistency</a></li>
					<li><a href="#sssec-validity">7.3.2 Validity</a></li>
				</ol></li>
				<li><a href="#ssec-succinctness">7.4. Succinctness</a>
				<ol>
					<li><a href="#sssec-conciseness">7.4.1 Conciseness</a></li>
					<li><a href="#sssec-representational-conciseness">7.4.2 Representational conciseness</a></li>
					<li><a href="#sssec-understandability">7.4.3 Understandability</a></li>
				</ol></li>
				<li><a href="#ssec-other-quality">7.5. Other Quality Dimensions</a></li>
			</ol></li>
			<li><a href="#chap-refine">8. Refinement</a>
			<ol>
				<li><a href="#ssec-completion">8.1. Completion</a>
				<ol>
					<li><a href="#sssec-general-link-prediction">8.1.1 General link prediction</a></li>
					<li><a href="#sssec-type-link-prediction">8.1.2 Type-link prediction</a></li>
					<li><a href="#sssec-identity-link-prediction">8.1.3 Identity-link prediction</a></li>
				</ol></li>
				<li><a href="#ssec-correction">8.2. Correction</a>
				<ol>
					<li><a href="#sssec-fact-validation">8.2.1 Fact validation</a></li>
					<li><a href="#sssec-inconsistency-repairs">8.2.2 Inconsistency repairs</a></li>
				</ol></li>
				<li><a href="#ssec-other-refinement-tasks">8.3. Other Refinement Tasks</a></li>
			</ol></li>
			<li><a href="#chap-publish">9. Publication</a>
			<ol>
				<li><a href="#ssec-principles">9.1. Best Practices</a>
				<ol>
					<li><a href="#ssec-fair">9.1.1 FAIR Principles</a></li>
					<li><a href="#sssec-ld">9.1.2 Linked Data Principles</a></li>
				</ol></li>
				<li><a href="#ssec-access">9.2. Access Protocols</a>
				<ol>
					<li><a href="#sssec-dumps">9.2.1 Dumps</a></li>
					<li><a href="#sssec-node-lookups">9.2.2 Node lookups</a></li>
					<li><a href="#sssec-edge-patterns">9.2.3 Edge patterns</a></li>
					<li><a href="#sssec-graph-patterns">9.2.4 (Complex) graph patterns</a></li>
					<li><a href="#sssec-other-protocols">9.2.5 Other protocols</a></li>
				</ol></li>
				<li><a href="#ssec-UsageControl">9.3. Usage Control</a>
				<ol>
					<li><a href="#sssec-licensing">9.3.1 Licensing</a></li>
					<li><a href="#sssec-usage-policies">9.3.2 Usage policies</a></li>
					<li><a href="#sssec-encryption">9.3.3 Encryption</a></li>
					<li><a href="#sssec-anonymisation">9.3.4 Anonymisation</a></li>
				</ol></li>
			</ol></li>
			<li><a href="#chap-kgs">10. Knowledge Graphs in Practice</a>
			<ol>
				<li><a href="#sec-openkgs">10.1. Open Knowledge Graphs</a>
				<ol>
					<li><a href="#sssec-dbpedia">10.1.1 DBpedia</a></li>
					<li><a href="#sssec-yago">10.1.2 Yet Another Great Ontology</a></li>
					<li><a href="#sssec-freebase">10.1.3 Freebase</a></li>
					<li><a href="#sssec-wikidata">10.1.4 Wikidata</a></li>
					<li><a href="#sssec-other-open-kgs">10.1.5 Other open cross-domain knowledge graphs</a></li>
					<li><a href="#sssec-domain-specific-open-kgs">10.1.6 Domain-specific open knowledge graphs</a></li>
				</ol></li>
				<li><a href="#ssec-enterprise-kgs">10.2. Enterprise Knowledge Graphs</a>
				<ol>
					<li><a href="#sssec-web-search">10.2.1 Web search</a></li>
					<li><a href="#sssec-commerce">10.2.2 Commerce</a></li>
					<li><a href="#sssec-social-networks">10.2.3 Social networks</a></li>
					<li><a href="#sssec-finance">10.2.4 Finance</a></li>
					<li><a href="#sssec-other-industries">10.2.5 Other industries</a></li>
				</ol></li>
			</ol></li>
			<li><a href="#chap-conclude">11. Summary and Conclusion</a></li>
			<li id="toc-ref"><a href="#sec-references">Bibliography</a></li>
			<li class="toc-app"><a href="#chap-defs">A. Background</a>
			<ol>
				<li><a href="#app-historical">A.1. Historical Perspective</a></li>
				<li><a href="#app-pre2012">A.2. “Knowledge Graphs”: Pre 2012</a></li>
				<li><a href="#app-post2012">A.3. “Knowledge Graphs”: 2012 Onwards</a></li>
			</ol></li>
			<li><a href="#sec-bio">Authors’ Biography</a></li>
			<li id="toc-filler">&nbsp;</li>
			<li id="aboutlink"><a href="#access">Give us feedback!</a></li>
		</ol>
	</nav>
