ul.menu {
    margin-bottom: 0;
    border-bottom: 1px solid rgba(0,0,0,0.20);
}

ul.menu.light { border-bottom: 1px solid rgba(255,255,255,0.20); }

ul.menu li {
    list-style-type: none;
    margin: 0;
}

ul.menu li a, ul.menu li.caption {
    display: block;
    width: 100%;
    line-height: 3rem;
    padding: 1rem 2rem;
    text-decoration: none;
}

ul.menu.light li a {
    color: white;
    background: [primary-color];
}

ul.menu.horizontal { border-bottom: 0; }

ul.menu.horizontal li { display: inline-block; }

ul.menu.horizontal li:last-child a { padding-right: 0; }

ul.menu.horizontal li:first-child a { padding-left: 0; }

.icon-nav, .icon-gear, .icon-edit {
    background-image: url("data:image/svg+xml;utf8,<svg xmlns='http://www.w3.org/2000/svg' x='0px' y='0px' width='30px' height='30px' viewBox='0 0 30 30' enable-background='new 0 0 30 30' xml:space='preserve'><rect width='30' height='4'/><rect y='24' width='30' height='4'/><rect y='12' width='30' height='4'/></svg>");
    background-size: contain;
    width: 2rem;
    height: 2rem;
    display: inline-block;
    line-height: 4rem;
    vertical-align: middle;
}

.icon-gear {
    background-image: url("data:image/svg+xml;utf8,<svg xmlns='http://www.w3.org/2000/svg' width='24' height='24' viewBox='0 0 24 24'><path d='M20 13.44v-2.88l-1.8-.3c-.1-.397-.3-.794-.6-1.39l1.1-1.49-2.1-2.088-1.5 1.093c-.5-.298-1-.497-1.4-.596L13.5 4h-2.9l-.3 1.79c-.5.098-.9.297-1.4.595L7.4 5.292 5.3 7.38l1 1.49c-.3.496-.4.894-.6 1.39l-1.7.2v2.882l1.8.298c.1.497.3.894.6 1.39l-1 1.492 2.1 2.087 1.5-1c.4.2.9.395 1.4.594l.3 1.79h3l.3-1.79c.5-.1.9-.298 1.4-.596l1.5 1.092 2.1-2.08-1.1-1.49c.3-.496.5-.993.6-1.39l1.5-.3zm-8 1.492c-1.7 0-3-1.292-3-2.982 0-1.69 1.3-2.98 3-2.98s3 1.29 3 2.98-1.3 2.982-3 2.982z'/></svg>");
    width: 3rem;
    height: 3rem;
}

.icon-edit {
    background-image: url("data:image/svg+xml;utf8,<svg xmlns='http://www.w3.org/2000/svg' x='0px' y='0px' viewBox='0 0 1000 1000' enable-background='new 0 0 1000 1000' xml:space='preserve'><g><path d='M500,10C229.4,10,10,229.4,10,500c0,270.6,219.4,490,490,490c270.6,0,490-219.4,490-490C990,229.4,770.6,10,500,10z M344.2,767.1H232.9V655.8l328-328l111.3,111.3L344.2,767.1z M758.2,353.1L703.3,408L592,296.7l54.9-54.9c11.9-11.9,29.7-11.9,41.5,0l69.8,69.8C770.1,323.4,770.1,341.2,758.2,353.1z'/></g></svg>");
}

[data-close], [data-open], [data-toggle], [data-delete], [data-post], [data-put], [data-get] { cursor: pointer; }
