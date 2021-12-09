# KG Book in HTML

This is the repository where we put the sources for the [HTML version](https://kgbook.org/) of the book [*Knowledge Graphs*](https://www.morganclaypool.com/doi/abs/10.2200/S01125ED1V01Y202109DSK022) by Hogan et al., published by Morgan & Claypool.
The book is itself an extended version of [the technical report](https://arxiv.org/abs/2003.02320) with the same title and authors.
There is also an [HTML version of the technical report](https://www.emse.fr/~zimmermann/KG).

The HTML version was generated from PHP scripts, regex search replace, and a lot of perspiration. The bibliography is partly generated using [bibtexbrowser](https://www.monperrus.net/martin/bibtexbrowser/), a PHP library by Martin Monperrus available under the GNU General Public License. The math formulas are generated from LaTeX code using [KaTeX](https://katex.org/), a JavaScript libray available under the MIT License. The syntax highlight for HTML in [Figure&nbsp;6.2](https://kgbook.org/#fig-html) and the BibTeX code in the bibliography and the preamble are rendered using [Prism](https://prismjs.com/), a JavaScript library under the MIT License. The BibTeX file used for the bibliography was made by the authors. Most figures are in Scalable Vector Graphic, generated from [Ti*k*Z](https://pgf-tikz.github.io/) figures used in the LaTeX version of the technical report. All other PHP scripts, CSS, HTML files were created by [Antoine Zimmermann](https://w3id.org/people/az/cv). The picture at the top of the HTML page uses the background image of the book cover from Morgan & Claypool (used with authorisation) on which is added text in HTML with hyperlinks to the [authors' biographies](https://kgbook.org/#sec-bio).

The fonts used in the HTML page are all freely available:
* The main text uses [Charis SIL](https://software.sil.org/charis/), available under [SIL Open Font License](https://scripts.sil.org/cms/scripts/page.php?site_id=nrsi&id=OFL)
* The titles of the chapters and sections use [Quattrocento](https://fonts.google.com/specimen/Quattrocento), a Google Font available under SIL Open Font License
* The teletype font (i.e., fixed width font) is [Hasklig](https://github.com/i-tu/Hasklig), available under SIL Open Font License
* The font used in the directed edge-labelled graphs (at nodes and edges) is cmss8, a font available from the [Comprehensive T<sub>E</sub>X Archive Network](https://www.ctan.org/) under a [non-free license](https://www.ctan.org/license/other-nonfree), copyright 1994 Basil K. Malyshev.
* The fonts used in the math formulas are packaged with the KaTeX JavaScript library.

The typography of the web page was influenced by Matthew Butterick's [practical typography](https://practicaltypography.com/) and are taking elements from Morgan & Claypool's book version, especially the colours.
