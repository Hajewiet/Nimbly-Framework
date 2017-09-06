/*
 * Base CSS based on Milligram CSS framework
 * MIT license: https://cjpatoilo.mit-license.org/
 */

 form, fieldset, input, select, textarea {margin-bottom: 1.5rem; }

 .form-alert { color: red; }

.button {
    background-color: [primary-color];
    border: 0.1rem solid [primary-color];
    border-radius: .4rem;
    color: #fff;
    cursor: pointer;
    display: inline-block;
    font-size: 1.1rem;
    font-weight: 700;
    height: 3.8rem;
    letter-spacing: .1rem;
    line-height: 3.8rem;
    padding: 0 3.0rem;
    text-align: center;
    text-decoration: none;
    text-transform: uppercase;
    white-space: nowrap;
    margin-bottom: 1.0rem;
}

.button:focus, .button:hover {
    filter: brightness(95%);
    outline: 0;
}

.button.icon-button {
    padding: 0 1.0rem;
    line-height: 3.5rem;
    border-radius: 0;
}

#top-bar-fixed .button.icon-button {
    background-color: transparent;
    border: 0.1rem solid transparent;
}

.button.icon-button.active { border-bottom: 3px solid [secondary-color]; }

#top-bar-fixed .button.icon-button.active { border-bottom: 3px solid [secondary-color]; }


.button[disabled], button[disabled]:focus, .button[disabled]:hover {
    cursor: default;
    filter: grayscale(100%);
    opacity: .5;
}

.button-outline, button-outline:focus, .button-outline:hover {
    background-color: transparent;
    color: [primary-color];
}

.button-outline:focus, .button-outline:hover {
    filter: brightness(80%);
}

.button-outline[disabled]:focus, .button.button-outline[disabled]:hover {
    filter: grayscale(100%);
    opacity: .5;
}

.button.button-clear {
    background-color: transparent;
    border-color: transparent;
    color: [primary-color];
}

.button.button-clear:focus, .button.button-clear:hover {
    filter: brightness(80%);
}

.button.button-clear[disabled]:focus, .button.button-clear[disabled]:hover {   color: #333; }

input[type='email'], input[type='number'], input[type='password'], input[type='search'], input[type='tel'], input[type='text'], input[type='url'], textarea, select {
    -webkit-appearance: none;
    -moz-appearance: none;
    appearance: none;
    background-color: transparent;
    border: 0.1rem solid #ccc;
    border-radius: .4rem;
    box-shadow: none;
    box-sizing: inherit;
    height: 3.8rem;
    padding: .6rem 1.0rem;
    width: 100%;
}

input[type='email']:focus, input[type='number']:focus, input[type='password']:focus, input[type='search']:focus, input[type='tel']:focus,
input[type='text']:focus, input[type='url']:focus, textarea:focus, select:focus {
    border-color: [primary-color];
    outline: 0;
}

select {
    background: url('data:image/svg+xml;utf8,<svg xmlns="http://www.w3.org/2000/svg" height="14" viewBox="0 0 29 14" width="29"><path fill="#d1d1d1" d="M9.37727 3.625l5.08154 6.93523L19.54036 3.625"/></svg>') center right no-repeat;
    padding-right: 3.0rem;
}

select:focus { background-image: url('data:image/svg+xml;utf8,<svg xmlns="http://www.w3.org/2000/svg" height="14" viewBox="0 0 29 14" width="29"><path fill="#9b4dca" d="M9.37727 3.625l5.08154 6.93523L19.54036 3.625"/></svg>'); }

textarea { min-height: 6.5rem; }

label, legend {
    display: block;
    font-size: 1.6rem;
    font-weight: 700;
    margin-bottom: .5rem;
}

fieldset {
    border-width: 0;
    padding: 0;
}

input[type='checkbox'], input[type='radio'] { display: inline; }

.label-inline {
    display: inline-block;
    font-weight: normal;
    margin-left: .5rem;
}

