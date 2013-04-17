(function() {
    tinymce.create('tinymce.plugins.mw_shortcodes_plugin', {
        init: function(ed, url) {

            ed.addCommand('add_row_fluid', function() {
                selected = tinyMCE.activeEditor.selection.getContent();

                if (selected)
                {
                    content = '[mw-row-fluid]<br class="quebra"><br class="quebra"> ' + selected + ' <br class="quebra"><br class="quebra">[/mw-row-fluid]';
                }
                else
                {
                    content = '[mw-row-fluid]<br class="quebra"><br class="quebra"> As colunas vão aqui... <br class="quebra"><br class="quebra">[/mw-row-fluid]';
                }

                tinymce.execCommand('mceInsertContent', false, content);

            });

            ed.addButton('mw_row_fluid', {
                title: 'Add Row-Fluid',
                image: url + '/icons/mw-row-fluid.png',
                cmd: 'add_row_fluid'
            });

            ed.addCommand('add_spans', function() {
                var colunas = prompt('Digite a quantidades de colunas de 1 a 12!');

                if (colunas == undefined || colunas == '' || colunas <= 0 || colunas > 12 || !parseInt(colunas))
                {
                    colunas = 12;
                }

                selected = tinyMCE.activeEditor.selection.getContent();

                if (selected)
                {
                    content = '[mw-span-x colunas="'+ colunas +'"]<br class="quebra"><br class="quebra"> ' + selected + ' <br class="quebra"><br class="quebra">[/mw-span-x]<br class="quebra"><br class="quebra">';
                }
                else
                {
                    content = '[mw-span-x colunas="'+ colunas +'"]<br class="quebra"><br class="quebra"> Conteúdo vai aqui... <br class="quebra"><br class="quebra">[/mw-span-x]<br class="quebra"><br class="quebra">';
                }

                tinymce.execCommand('mceInsertContent', false, content);

            });

            ed.addButton('mw_add_spans', {
                title: 'Add Coluna Span',
                image: url + '/icons/mw-spans.png',
                cmd: 'add_spans'
            });
        },
        createControl: function(n, cm) {
            return null;
        },
        getInfo: function() {
            return {
                longname: "MW ShortCodes",
                author: 'Missão Web',
                authorurl: 'http://www.misssaoweb.com.br',
                version: "1.0"
            };
        }
    });

    tinymce.PluginManager.add('mw_row_fluid', tinymce.plugins.mw_shortcodes_plugin);
    tinymce.PluginManager.add('mw_add_spans', tinymce.plugins.mw_shortcodes_plugin);
})();