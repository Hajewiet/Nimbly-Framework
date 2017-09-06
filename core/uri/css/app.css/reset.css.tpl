/*
 * Base CSS based on Milligram CSS framework
 * MIT license: https://cjpatoilo.mit-license.org/
 */

*, *:after, *:before { box-sizing: inherit; }

html {
    box-sizing: border-box;
    font-size: 62.5%;
}

body {
    font-family: sans-serif;
    font-size: 1.6em;
    font-weight: 300;
    line-height: 1.6;
    margin: 0;
    padding: 0;
}

blockquote {
    border-left: 0.3rem solid [primary-color];
    margin-left: 0;
    margin-right: 0;
    padding: 1rem 1.5rem;
}

blockquote *:last-child { margin-bottom: 0; }

code {
    background: #eee;
    border-radius: .4rem;
    font-size: 86%;
    margin: 0 .2rem;
    padding: .2rem .5rem;
    white-space: nowrap;
}

pre {
    background: #eee;
    border-left: 0.3rem solid [primary-color];
    overflow-y: hidden;
}

pre > code {
    border-radius: 0;
    display: block;
    padding: 1rem 1.5rem;
    white-space: pre;
}

hr {
    border: 0;
    border-top: 0.1rem solid [primary-color];
    margin: 3.0rem 0;
}

dd, dt, li { margin-bottom: 1.0rem; }

blockquote, dl, figure, ol, p, pre, table, ul { margin-bottom: 2.5rem; }

table {
    border-spacing: 0;
    width: 100%;
}

td, th {
    border-bottom: 0.1rem solid #ddd;
    padding: 1.2rem 1.5rem;
    text-align: left;
}

td:first-child,
th:first-child {
  padding-left: 0;
}

td:last-child, th:last-child { padding-right: 0; }

img {
    max-width: 100%;
    height: auto;
}

.clearfix:after {
    clear: both;
    content: ' ';
    display: table;
}

.float-left { float: left; }

.float-right { float: right; }

.scroll-h { overflow-x: auto; }
