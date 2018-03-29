<section class="nb-container medium">
    <form class="nb-form">
        <label>Resource Name:
            <input type="text" maxlength="64" name="resource"
                   placeholder="resource name, e.g. `books`" value="[sticky resource]" required />
        </label>

        <fieldset id="field_entry">
            <label>Fields:</label>
            [set row-id=[uuid]]
            <div class="nb-field" id="nb-field-1">
                <input
                    type="text"
                    name="field_names"
                    class="field_name nb-40"
                    maxlength="64"
                    placeholder="field name, e.g. `title`"
                />
                <select name="field_types" class="nb-40">
                    <option value="text">Text</option>
                    <option value="date">Date</option>
                    <option value="boolean">Boolean</option>
                    <option value="image">Image</option>
                    <option value="block-plain-text">Inline plain text</option>
                    <option value="block-text">Inline text</option>
                    <option value="block-html">Inline HTML</option>
                    <option value="select">Select</option>
                </select>
                <input type="button" class="nb-button nb-button-outline nb-button-delete" value="x" data-close="#nb-field-1" />
            </div>
        </fieldset>

        <input type="button" class="nb-button nb-button-outline" id="button-add-field" value="+ Field" />
        <input
            type="submit"
            value="Save"
            class="nb-button"
            data-post=".resources"
            data-done='{"redirect": "admin/resources", "msg": "Resource created"}'
        />

    </form>
</section>
