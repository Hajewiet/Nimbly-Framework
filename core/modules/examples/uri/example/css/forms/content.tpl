<h2>Forms</h2>

<form method="post" action="[url]" class="space top">
    [form-key]
    <h3>1. Standard form</h3>
    <br />
    <label for="example1">Default Input Field</label>
    <input type="text" name="example1" id="example1" />

    <label for="example2">Large Input Field</label>
    <input type="text" name="example2" id="example2" class="large" />

    <label for="example3">Small Input Field</label>
    <input type="text" name="example3" id="example3" class="small" />

    <fieldset>
        <legend>Fieldset</legend>
        <fieldset>
            <legend>Radio Buttons</legend>
            <div class="group">
                <input type="radio" name="example4" value="option1" id="option1" /> 
                <label for="option1" class="inline">Option 1</label>
            </div>
            <div class="group">
                <input type="radio" name="example4" value="option2" id="option2" />
                <label for="option2" class="inline">Option 2</label>
            </div>
        </fieldset>

        <fieldset>
            <legend>Checkboxes</legend>
            <div class="group">
                <input type="checkbox" name="example5" value="check1" id="check1">
                <label for="check1" class="inline">Checkbox 1</label>
            </div>
            <div class="group">
                <input type="checkbox" name="example5" value="check2" id="check2">
                <label for="check2" class="inline"> Checkbox 2</label>
            </div>
        </fieldset>
    </fieldset>

    <label for="exmaple6">Textarea</label>
    <textarea name="example6" id="example6"></textarea>

    <label for="example7">Select</label>
    <select name="example7" id="example7">
        <option value="Chrome">Chrome</option>
        <option value="Firefox">Firefox</option>
        <option value="Internet Explorer">Internet Explorer</option>
        <option value="Opera">Opera</option>
        <option value="Safari">Safari</option>
    </select>

    <label>
        <input type="submit" name="default-form-example" value="Primary Button" class="primary button" />
    </label>

    <label>
        <input type="button" name="default-button" value="Normal Button" class="button" />
    </label>
    
    <label>
        <input type="reset" name="default-reset" value="Secondary Button" class="secondary button" />
    </label>
    
     

</form>

<form method="post" action="[url]" class="inline large space top">
    [form-key]
    <h3>2. Inline form</h3>
    <br />
    <label for="example8">Default Input Field</label>
    <input type="text" name="example8" id="example8" />
    <div class="group">
        <input type="checkbox" name="example9" value="check1" id="checka">
        <label for="checka" class="inline">Checkbox 1</label>
    </div>
    <div class="group">
        <input type="checkbox" name="example9" value="check2" id="checkb">
        <label for="checkb" class="inline">Checkbox 2</label>
    </div>
    <label>
        <input type="submit" name="inline-form-example" value="Small Button" class="small button" />
    </label>
</form>

<form method="post" action="[url]" class="clearfix large space top">
    [form-key]
    <h3>3. Labels on the left</h3>
    <br />
    <label for="example10" class="left">Default Input Field</label>
    <input type="text" name="example10" id="example8" class="right" />

    <label for="example11" class="left">Textarea</label>
    <textarea class="right" id="example11" name="example11"></textarea>

    <label class="left"></label>
    <div class="right">
        <div class="group">
            <label>
                <input type="checkbox" name="example12" value="check1" id="checkc"> 
                Checkbox 1
            </label>
        </div>
        <div class="group">
            <input type="checkbox" name="example12" value="check2" id="checkd">
            <label for="checkd" class="inline">Checkbox 2</label>
        </div>
    </div>

    <label class="left"></label>
    <input type="submit" name="inline-form-example" value="Submit" class="right primary" />

</form>

<form method="post" class="large space top bottom">
    <h3>4. HTML5 Input Fields</h3>
    <br />
    <p>Examples from <a href="http://www.w3schools.com/html/html5_form_input_types.asp">W3Schools</a></p> 
    
     <label for="browsers">What browser do you use?</label>
    <input list="browsers" name="browser">
    <datalist id="browsers">
        <option value="Internet Explorer">
        <option value="Firefox">
        <option value="Chrome">
        <option value="Opera">
        <option value="Safari">
    </datalist>
    <div class="help">HTML5 Datalist example</div><br/>
    
    Select your favorite color: <input type="color" name="favcolor"> <br /><br />
    Birthday: <input type="date" name="bday"><br /><br />
    Birthday (date and time): <input type="datetime-local" name="bdaytime"><br /><br />
    Birthday (month and year): <input type="month" name="bdaymonth"><br /><br />
    Quantity (between 1 and 5): <input type="number" name="quantity" min="1" max="5"><br /><br />
    Range slider (between 1 and 10): <input type="range" name="points" min="1" max="10"><br /><br />
    Search Google: <input type="search" name="googlesearch"><br /><br />
    Select a week: <input type="week" name="week_year"><br /><br />
    
</form>
