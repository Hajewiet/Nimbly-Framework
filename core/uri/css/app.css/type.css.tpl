/*
 * Base CSS based on Milligram CSS framework
 * MIT license: https://cjpatoilo.mit-license.org/
 */

b, strong { font-weight: bold; }

p { margin-top: 0; }

h1, h2, h3, h4, h5, h6 {
    font-weight: 300;
    margin-bottom: 2.0rem;
    margin-top: 0;
}

h1 {
    font-size: 4.6rem;
    line-height: 1.2;
}

h2 {
    font-size: 3.6rem;
    line-height: 1.25;
}

h3 {
    font-size: 2.8rem;
    line-height: 1.3;
}

h4 {
    font-size: 2.2rem;
    letter-spacing: -.08rem;
    line-height: 1.35;
}

h5 {
    font-size: 1.8rem;
    letter-spacing: -.05rem;
    line-height: 1.5;
}

h6 {
    font-size: 1.6rem;
    letter-spacing: 0;
    line-height: 1.4;
}

dl, ol, ul {
    list-style: none;
    margin-top: 0;
    padding-left: 0;
}

dl dl, dl ol, dl ul, ol dl, ol ol, ol ul, ul dl, ul ol, ul ul {
    font-size: 90%;
    margin: 1.5rem 0 1.5rem 3.0rem;
}

ol { list-style: decimal inside; }

ul { list-style: circle inside; }

.small { font-size: 1.25rem; }

.align-right { text-align: right; }

.align-center, .center { text-align: center; }

.align-left { text-align: left; }

.align-justify { text-align: justify; }

.break-words {
    overflow-wrap: break-word;
    word-wrap: break-word;
    word-break: break-all;
    word-break: break-word;
    hyphens: auto;
}
