<td>
    [if field.type="password" echo="(secret)"]
    [if field.type="text" echo="[get record.[field.key] default=(empty)]"]
    [if field.type="date" echo="[get record.[field.key] default=(empty)]"]
</td>
