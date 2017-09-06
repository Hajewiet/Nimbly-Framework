.open { display: inherit; }

.close , div.close, li.close, ul.close { display: none; }

.container {
    margin: 0 auto;
    max-width: 1240px;
    padding: 0 2.0rem;
    position: relative;
    width: 100%;
}

.container.medium { max-width: 640px; }

.container.large { max-width: 960px; }

.callout {
    padding: 1rem;
    border-left: 0.3rem solid [primary-color];
    margin-bottom: 1rem;
    background-color: #eee;
}

.callout p {
    margin-bottom: 0;
}

.callout a[data-close] {
    text-decoration: none;
    cursor: pointer
}

.notification {
    position: fixed;
    top: 4rem;
    right: 0;
    text-align: right;
    padding: 0 1rem;
    background: [primary-color];
    font-size: 1.4rem;
    line-height: 2rem;
    border-radius: 4px;
}

.notification p {
    margin-bottom: 0;
    margin-right: 1.4rem;
    color: #fff;
}

.notification a { color: #fff; }

#top-bar-fixed {
    position: fixed;
    top: 0;
    left: 0;
    right: 0;
    height: 3.8rem;
    background: [primary-color];
    z-index: 1000;
}

#top-bar-fixed h1.top-center {
    position: fixed;
    top: 0px;
    left: 0px;
    right: 0px;
    text-align: center;
    font-size: 2rem;
    line-height: 3.8rem;
    z-index: -1;
    height: 3.8rem;
    overflow: hidden;
}

#top-bar-fixed + div, #top-bar-fixed + section, #top-bar-fixed + .container { margin-top: 6rem; }

#off-left-panel, #off-right-panel {
    position: fixed;
    z-index: 1;
    top: 3.8rem;
    left: 0;
    bottom: 0;
    background-color: [primary-color];
    overflow-x: hidden;
    transition: width 0.3s;
    transition-timing-function: ease-in-out;
    width: 0;
}

#off-right-panel {
    right: 0;
    left: auto;
}

#off-left-panel.open, #off-right-panel.open { width: 300px; }

#off-left-panel.close, #off-right-panel.close  { display: inherit; }

#modal {
    position: fixed;
    top: 0;
    bottom: 0;
    left: 0;
    right: 0;
    background: rgba(0,0,0,0.6);
    z-index: 9999;
    display: flex;
    align-items: center;
    justify-content: center;
    padding: 2.0rem;
}

#modal.close {
    display: none;
}

#modal-content {
    max-width: 680px;
    min-width: 480px;
    background: white;
    height: 100%;
    padding: 5rem 1rem 1rem 1rem;
    position: relative;
}

.small-screen #modal-content {
    min-width: 100%;
}

#modal-content .icon-close {
    position: absolute;
    top: 0;
    right: 0;
    padding: 1rem;
    font-size: 2rem;
    line-height: 2rem;
}

#modal-content .modal-caption {
    position: absolute;
    top: 0;
    right: 0;
    left: 0;
    font-size: 1.5rem;
    line-height: 4rem;
    text-align: center;
    text-transform: uppercase;
}

#modal-content .modal-content {
    overflow-y: auto;
    height: 100%;
}

#page-wrapper {
    position: relative;
    width: 100%;
    overflow: hidden;
}

#page {
    transition: margin-left 0.3s;
    transition-timing-function: ease-in-out;
    width: 100%;
}

#page-wrapper.push-right #page {
    margin-left: 300px;
}

.medium-screen .only-sm, .large-screen .only-sm { display: none; }

.small-screen .only-md, .large-screen .only-md { display: none; }

.small-screen .only-lg, .medium-screen .only-lg { display: none; }

.large-screen .only-lg { display: inherit; }

.medium-screen .only-md { display: inherit; }

.small-screen .only-sm { display: inherit; }
