[set php_ok=[require php_version=5.0.0]]
[set server_ok=[require server=apache apache_version=2.0.0]]
[set modules_ok=[require apache_module=mod_rewrite]]
[set data_dir_ok=[require cond=[setup-data-dir]]]
[set data_write_ok=[require write_access=data]]

[if require=fail tpl=step1_fail]

[if php_ok=fail tpl=require_php]
[if server_ok=fail tpl=require_server]
[if modules_ok=fail tpl=require_mods]
[if data_dir_ok=fail tpl=require_data_dir]
[if data_write_ok=fail tpl=require_data_write]

[ifnot require=fail tpl=step1_pass]
