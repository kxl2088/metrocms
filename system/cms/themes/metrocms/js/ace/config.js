/**
 * Metro object
 *
 * The Metro object is the foundation of all PyroUI enhancements
 */
// It may already be defined in metadata partial
if (typeof(metro) == 'undefined') {
	var metro = {};
}
$(document).ready(function(){

    metro.init_ace_editor = function(){
         
        // HTML EDITOR
        $('.html_editor').each(function(index) {
            var $ace_html = $(this);

            $ace_html.css('display', 'none')
                     .after('<div class="ace_edit_html" id="html_editor' + index + '">' + $ace_html.html() + '</div>');

            var html_editor = ace.edit("html_editor"+index);
            html_editor.setTheme("ace/theme/github");
            html_editor.getSession().setMode("ace/mode/html");

            html_editor.getSession().getDocument().on('change', function(){
                $ace_html.html(html_editor.getValue());
            });

            $('form').submit(function(){
                $ace_html.html(html_editor.getValue());
            });
        });

        // CSS EDITOR
        $('.css_editor').each(function(index) {
            var $ace_css = $(this);

            $ace_css.css('display', 'none')
                    .after('<div class="ace_edit_css" id="css_editor' + index + '">' + $ace_css.html() + '</div>');

            var css_editor = ace.edit("css_editor"+index);
            css_editor.setTheme("ace/theme/github");
            css_editor.getSession().setMode("ace/mode/css");

            css_editor.getSession().getDocument().on('change', function(){
                $ace_css.html(css_editor.getValue());
            });

            $('form').submit(function(){
                $ace_css.html(css_editor.getValue());
            });
        });

        // JAVASCRIPT EDITOR
        $('.js_editor').each(function(index) {
            var $ace_js = $(this);

            $ace_js.css('display', 'none')
                   .after('<div class="ace_edit_js" id="js_editor' + index + '">' + $ace_js.html() + '</div>');

            var js_editor = ace.edit("js_editor"+index);
            js_editor.setTheme("ace/theme/github");
            js_editor.getSession().setMode("ace/mode/javascript");

            js_editor.getSession().getDocument().on('change', function(){
                $ace_js.html(js_editor.getValue());
            });

            $('form').submit(function(){
                $ace_js.html(js_editor.getValue());
            });
        });  

        // MARKDOWN EDITOR
        $('.markdown_editor').each(function(index) {
            var $ace_markdown = $(this);

            $ace_markdown.css('display', 'none')
                         .after('<div class="ace_edit_markdown" id="markdown_editor' + index + '">' + $ace_markdown.html() + '</div>');

            var markdown_editor = ace.edit("markdown_editor"+index);
            markdown_editor.setTheme("ace/theme/github");
            markdown_editor.getSession().setMode("ace/mode/markdown");

            markdown_editor.getSession().getDocument().on('change', function(){
                $ace_markdown.html(markdown_editor.getValue());
            });

            $('form').submit(function(){
                $ace_markdown.html(markdown_editor.getValue());
            });
        });

        // XML EDITOR
        $('.xml_editor').each(function(index) {
            var $ace_xml = $(this);

            $ace_xml.css('display', 'none')
                    .after('<div class="ace_edit_xml" id="xml_editor' + index + '">' + $ace_xml.html() + '</div>');

            var xml_editor = ace.edit("xml_editor"+index);
            xml_editor.setTheme("ace/theme/github");
            xml_editor.getSession().setMode("ace/mode/xml");

            xml_editor.getSession().getDocument().on('change', function(){
                $ace_xml.html(xml_editor.getValue());
            });

            $('form').submit(function(){
                $ace_xml.html(xml_editor.getValue());
            });
        });

        // SQL EDITOR
        $('.sql_editor').each(function(index) {
            var $ace_sql = $(this);

            $ace_sql.css('display', 'none')
                    .after('<div class="ace_edit_sql" id="sql_editor' + index + '">' + $ace_sql.html() + '</div>');

            var sql_editor = ace.edit("sql_editor"+index);
            sql_editor.setTheme("ace/theme/github");
            sql_editor.getSession().setMode("ace/mode/sql");

            sql_editor.getSession().getDocument().on('change', function(){
                $ace_sql.html(sql_editor.getValue());
            });

            $('form').submit(function(){
                $ace_sql.html(sql_editor.getValue());
            });
        });  

        // JAVA EDITOR
        $('.java_editor').each(function(index) {
            var $ace_java = $(this);

            $ace_java.css('display', 'none')
                     .after('<div class="ace_edit_java" id="java_editor' + index + '">' + $ace_java.html() + '</div>');

            var java_editor = ace.edit("java_editor"+index);
            java_editor.setTheme("ace/theme/github");
            java_editor.getSession().setMode("ace/mode/java");

            java_editor.getSession().getDocument().on('change', function(){
                $ace_java.html(java_editor.getValue());
            });

            $('form').submit(function(){
                $ace_java.html(java_editor.getValue());
            });
        });
		
        // JSP EDITOR
        $('.jsp_editor').each(function(index) {
            var $ace_jsp = $(this);

            $ace_jsp.css('display', 'none')
                    .after('<div class="ace_edit_jsp" id="jsp_editor' + index + '">' + $ace_jsp.html() + '</div>');

            var jsp_editor = ace.edit("jsp_editor"+index);
            jsp_editor.setTheme("ace/theme/github");
            jsp_editor.getSession().setMode("ace/mode/jsp");

            jsp_editor.getSession().getDocument().on('change', function(){
                $ace_jsp.html(jsp_editor.getValue());
            });

            $('form').submit(function(){
                $ace_jsp.html(jsp_editor.getValue());
            });
        });

        // PHP EDITOR
        $('.php_editor').each(function(index) {
            var $ace_php = $(this);

            $ace_php.css('display', 'none')
                    .after('<div class="ace_edit_php" id="php_editor' + index + '">' + $ace_php.html() + '</div>');

            var php_editor = ace.edit("php_editor"+index);
            php_editor.setTheme("ace/theme/github");
            php_editor.getSession().setMode("ace/mode/php");

            php_editor.getSession().getDocument().on('change', function(){
                $ace_php.html(php_editor.getValue());
            });

            $('form').submit(function(){
                $ace_php.html(php_editor.getValue());
            });
        });
    };
    
    metro.init_ace_editor();
});