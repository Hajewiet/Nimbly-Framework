<section class="container medium">
    <form>
            <label>Resource Name:
                <input type="text" maxlength="64" name="resource"
                       placeholder="resource name, e.g. `books`" value="[sticky resource]" required />
            </label>

            <fieldset id="field_entry">
                <label>Fields:</label>
                [set row-id=[uuid]]
                <div class="row" id="row-1">
                        <div class="col">
                            <input
                                type="text"
                                name="field_names"
                                class="field_name"
                                maxlength="64"
                                placeholder="field name, e.g. `title`"
                            />
                        </div>
                        <div class="col">
                            <select name="field_types">
                                <option value="text">Text</option>
                                <option value="date">Date</option>
                                <option value="boolean">Boolean</option>
                                <option value="image">Image</option>
                                <option value="block-plain-text">Inline plain text</option>
                                <option value="block-text">Inline text</option>
                                <option value="block-html">Inline HTML</option>
                                <option value="select">Select</option>
                            </select>
                        </div>
                        <div class="col col-20">
                            <input type="button" class="button button-outline button-delete" value="x" data-close="#row-1" />
                        </div>
                </div>
            </fieldset>

            <input type="button" class="button button-outline" id="button-add-field" value="+ Field" />
            <input
                type="submit"
                value="Save"
                class="button"
                data-post=".resources"
                data-done='{"redirect": "admin/resources", "msg": "Resource created"}'
            />

      </form>
</section>
