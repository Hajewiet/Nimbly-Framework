<div id="main">
    <section class="container">
        <h1>Typography</h1>
        [ipsum format=html]

        <p>
            <a>Hyperlink (no href)</a>
            <a href="#">Hyperlink (href)</a>
            <em>Emphasis</em>
            <small>Small</small>
            <strong>Strong</strong>
            <u>Underline</u>
        </p>

        <h2>Heading 2</h2>
        <h3>Heading 3</h3>
        <h4>Heading 4</h4>
        <h5>Heading 5</h5>
        <h6>Heading 6</h6>

        <blockquote>
            <p><em>Blockquote</em></p>
        </blockquote>

        <ul>
          <li>Unordered list item 1</li>
          <li>Unordered list item 2</li>
        </ul>

        <ol>
          <li>Ordered list item 1</li>
          <li>Ordered list item 2</li>
        </ol>

        <dl>
          <dt>Description list item 1</dt>
          <dd>Description list item 1.1</dd>
        </dl>

    </section>

    <hr />

     <section class="container">
        <h1>Forms</h1>
        <form action="[url]" method="post">
          <fieldset>
              <label>Name</label>
              <input type="text" placeholder="Text input field">
              <label>Select</label>
              <select>
                <option>[ipsum words=4]</option>
                <option>[ipsum words=4]</option>
                <option>[ipsum words=4]</option>
                <option>[ipsum words=4]</option>
              </select>
              <label>Textarea</label>
              <textarea placeholder="[ipsum words=20]"></textarea>
              <div class="float-right">
                <input type="checkbox">
                <label class="label-inline">Check</label>
              </div>
              <a class="button" href="#">Default Button</a>
              <button class="button button-outline">Outlined Button</button>
              <input class="button button-clear" type="submit" value="Clear Button">
          </fieldset>
        </form>
    </section>

     <hr />

     <section class="container">
        <h1>Tables</h1>
        <table>
          <thead>
            <tr>
              <th>Name</th>
              <th>Age</th>
              <th>Height</th>
              <th>Location</th>
            </tr>
          </thead>
          <tbody>
            <tr>
              <td>Stephen Curry</td>
              <td>27</td>
              <td>1,91</td>
              <td>Akron, OH</td>
            </tr>
            <tr>
              <td>Klay Thompson</td>
              <td>25</td>
              <td>2,01</td>
              <td>Los Angeles, CA</td>
            </tr>
          </tbody>
        </table>
    </section>

     <hr />

    <section class="container">
            <h1>Flex Grid</h1>

            [set demo-col="background: #ccc; border-radius: 5px; text-align: center; line-height: 3em; margin-bottom: 2rem;"]

            <div class="row">
                <div class="col"><div style="[demo-col]">.col</div></div>
                <div class="col"><div style="[demo-col]">.col</div></div>
                <div class="col"><div style="[demo-col]">.col</div></div>
                <div class="col"><div style="[demo-col]">.col</div></div>
            </div>

            <h6>Offset:</h6>
            <div class="row">
                <div class="col"><div style="[demo-col]">.col</div></div>
                <div class="col col-50 col-offset-25"><div style="[demo-col]">.col (offset)</div></div>
            </div>

            <h6>No padding:</h6>
                <div class="row row-no-padding">
                <div class="col"><div style="[demo-col]">.col</div></div>
                <div class="col"><div style="[demo-col]">.col</div></div>
                <div class="col"><div style="[demo-col]">.col</div></div>
                <div class="col"><div style="[demo-col]">.col</div></div>
            </div>

            <h6>Center:</h6>
            <div class="row">
                <div class="col col-50 col-offset-25"><div style="[demo-col]">.col</div></div>
            </div>

    </section>
</div>

