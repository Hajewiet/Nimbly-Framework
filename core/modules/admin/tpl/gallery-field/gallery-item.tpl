[set gtmp.img=[get record.[item.key][x.key]] overwrite]
[if gtmp.img=(empty) echo="<img data-edit-img='[item.key][x.key]' data-empty=true src='[base-url]/img/placeholder.png'>"]
[if not gtmp.img=(empty) echo="<img data-edit-img='[item.key][x.key]' data-empty=false src='[base-url]/img/[gtmp.img]/150x150f'>"]

