/*
 * Base CSS based on Milligram CSS framework
 * MIT license: https://cjpatoilo.mit-license.org/
 */

.row {
    display: flex;
    flex-direction: column;
    padding: 0;
    width: 100%;
}

.row.wrap { flex-wrap: wrap; }

.row.row-no-padding { padding: 0; }

.row.row-no-padding > .col { padding: 0; }

.row.row-wrap { flex-wrap: wrap; }

.row.row-top { align-items: flex-start; }

.row.row-bottom { align-items: flex-end; }

.row.row-center { align-items: center; }

.row.row-stretch { align-items: stretch; }

.row.row-baseline { align-items: baseline; }

.row .col {
    display: block;
    flex: 1 1 auto;
    margin-left: 0;
    max-width: 100%;
    width: 100%;
}

[set col-sizes="5,10,15,20,25,30,40,50,60,70,75,80,85,90,95,100"]
[repeat csv data=col-sizes tpl=grid.col.css]

.row .col.col-offset-33 { margin-left: 33.3333%; }

.row .col.col-33 {
    flex: 0 0 33.3333%;
    max-width: 33.3333%;
}

.small-screen .row .col.col-sm-offset-33 { margin-left: 33.3333%; }

.small-screen .row .col.col-sm-33 {
    flex: 0 0 33.3333%;
    max-width: 33.3333%;
}

.medium-screen .row .col.col-md-offset-33 { margin-left: 33.3333%; }

.medium-screen .row .col.col-md-33 {
    flex: 0 0 33.3333%;
    max-width: 33.3333%;
}

.large-screen .row .col.col-lg-offset-33 { margin-left: 33.3333%; }

.large-screen .row .col.col-lg-33 {
    flex: 0 0 33.3333%;
    max-width: 33.3333%;
}

.row .col.col-66 {
    flex: 0 0 66.6666%;
    max-width: 66.6666%;
}

.small-screen .row .col.col-sm-offset-66 { margin-left: 66.6666%; }

.small-screen .row .col.col-sm-66 {
    flex: 0 0 66.6666%;
    max-width: 66.6666%;
}

.medium-screen .row .col.col-md-offset-66 { margin-left: 66.6666%; }

.medium-screen .row .col.col-md-66 {
    flex: 0 0 66.6666%;
    max-width: 66.6666%;
}

.large-screen .row .col.col-lg-offset-66 { margin-left: 66.6666%; }

.large-screen .row .col.col-lg-66 {
    flex: 0 0 66.6666%;
    max-width: 66.6666%;
}

.row .col .col-top { align-self: flex-start; }

.row .col .col-bottom { align-self: flex-end; }

.row .col .col-center {
    -ms-grid-row-align: center;
    align-self: center;
}

.medium-screen .row, .large-screen .row, .row.dir-row {
    flex-direction: row;
    margin-left: -1.0rem;
    width: calc(100% + 2.0rem);
}

.medium-screen .row .col, .large-screen .row .col, .row.dir-row .col {
    margin-bottom: inherit;
    padding: 0 1.0rem;
}

.medium-screen .row.row-no-padding, .large-screen .row.row-no-padding { padding: 0; }

.medium-screen .row.row-no-padding > .col, .large-screen .row.row-no-padding > .col { padding: 0; }

.img-grid {
    line-height: 0;
    -webkit-column-count: 3;
    -webkit-column-gap: 1rem;
    -moz-column-count: 3;
    -moz-column-gap: 1rem;
    column-count: 3;
    column-gap: 1rem;
    text-align: center;
}

.img-grid img { margin-bottom: 1rem; }

.small-screen .img-grid {
    -webkit-column-count: 2;
    -moz-column-count: 2;
    column-count: 2;
}

.pos-rel { position: relative; }
