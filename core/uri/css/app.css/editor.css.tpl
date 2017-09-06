[contenteditable=true], .editor.img-wrapper {
  box-shadow: 0 0 0 2px [primary-color];
  background-color: [rgba [primary-color] 0.1];
}

.uploader.img-wrapper, .editor.img-wrapper {
    display: inline-block;
    overflow: hidden;
    background: #eee;
    position: relative;
}

.editor.img-wrapper {
    background: inherit;
    line-height: 0;
}

.uploader.img-wrapper img {
    vertical-align: middle;
    cursor: pointer;
}

.progress-bar-bg, .progress-bar, .progress-bar-text {
    position: absolute;
    top: 40%;
    width: 100%;
    background: #ddd;
    opacity: .7;
    height: 2rem;
    line-height: 2rem;
    text-align: center;
    z-index: 498;
}

.progress-bar-text {
    background: none;
    z-index: 500;
    color: white;
    font-size: 1.25rem;
    text-transform: uppercase;
}

.progress-bar-bg .progress-bar {
    background: [primary-color];
    top: 0;
    width: 0%;
    opacity: 1;
    z-index: 499;
}

.img-grid[data-select] img { border: 2px solid transparent; }

.img-grid[data-select] img.selected { border: 2px solid [primary-color];  }

a.edit-img-icon {
    position: absolute;
    right: 0;
    bottom: 0;
    width: 3rem;
    height: 3rem;
    background: [primary-color];
    opacity: .8;
    line-height: 2.25rem;
    color: black;
    text-decoration: none;
    text-align: center;
    font-weight: 700;
}

a.editor.add-img-icon {
    position: absolute;
    display: block;
    width: 3rem;
    height: 3rem;
    left: -3.5rem;
    opacity: .8;
    text-decoration: none;
    line-height: 3rem;
    text-align: center;
    font-weight: bold;
    font-size: 2rem;
    display: none;
}

.editor.editor-active.img-insert a.editor.add-img-icon { display: block; }

.editor.img-insert { position: relative; }

/*
 * Style medium toolbar buttons
 */

.medium-toolbar-arrow-under:after {
    top: 40px;
    border-color: [primary-color] transparent transparent transparent;
}

.medium-toolbar-arrow-over:before {
    top: -8px;
    border-color: transparent transparent [primary-color] transparent;
}

.medium-editor-toolbar { background-color: [primary-color]; }

.medium-editor-toolbar li { padding: 0; }

.medium-editor-toolbar li button {
      min-width: 40px;
      height: 40px;
      border: none;
      line-height: 1rem!important;
      border-right: 1px solid rgba(0,0,0,0.2);
      background-color: transparent;
      color: #fff;
      -webkit-transition: background-color .2s ease-in, color .2s ease-in;
              transition: background-color .2s ease-in, color .2s ease-in;
}

.medium-editor-toolbar li button:hover {
        background-color: [secondary-color];
        color: #fff;
}

.medium-editor-toolbar li .medium-editor-button-active {
      background-color: [secondary-color];
      color: #fff;
}

.medium-editor-toolbar li .medium-editor-button-last { border-right: none; }

.medium-editor-toolbar-form .medium-editor-toolbar-input {
  height: 40px;
  background: [primary-color];
  color: #fff; }

.medium-editor-toolbar-form .medium-editor-toolbar-input::-webkit-input-placeholder {
    color: #fff;
    color: rgba(255, 255, 255, 0.8); }

.medium-editor-toolbar-form .medium-editor-toolbar-input:-moz-placeholder {
    /* Firefox 18- */
    color: #fff;
    color: rgba(255, 255, 255, 0.8);
}

.medium-editor-toolbar-form .medium-editor-toolbar-input::-moz-placeholder {
    /* Firefox 19+ */
    color: #fff;
    color: rgba(255, 255, 255, 0.8);
}

.medium-editor-toolbar-form .medium-editor-toolbar-input:-ms-input-placeholder {
    color: #fff;
    color: rgba(255, 255, 255, 0.8);
}

.medium-editor-toolbar-form a { color: #fff; }

.medium-editor-toolbar-anchor-preview {
  background: [primary-color];
  color: #fff;
}

.medium-editor-placeholder:after { color: [secondary-color]; }
