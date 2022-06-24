(function() {
    tinymce.create("tinymce.plugins.faqs_button", {

        /**
         * Add FAQs Button 
         * 'url' argument holds the absolute url of our plugin directory
         **/
        
        init : function(ed, url) {
            
            ed.addButton("faqs", {
                text : "FAQs",
                type  : 'menubutton',
                icon  : false,
                menu: [
                    {
                        text: 'FAQs',
                        onclick: function() {
                            ed.execCommand('mceInsertContent', 0, '[faqs]');
                        }
                    },
                    {
                        text: 'FAQs Grouped',
                        onclick: function() {
                            ed.execCommand('mceInsertContent', 0, '[faqs style="grouped"]');
                        }
                    },
                    {
                        text: 'FAQs Toggle',
                        onclick: function() {
                            ed.execCommand('mceInsertContent', 0, '[faqs style="toggle"]');
                        }
                    },
                    {
                        text: 'FAQs Accordion',
                        onclick: function() {
                            ed.execCommand('mceInsertContent', 0, '[faqs style="accordion"]');
                        }
                    },
                    {
                        text: 'FAQs Toggle Grouped',
                        onclick: function() {
                            ed.execCommand('mceInsertContent', 0, '[faqs style="toggle-grouped"]');
                        }
                    },
                    {
                        text: 'FAQs Accordion Grouped',
                        onclick: function() {
                            ed.execCommand('mceInsertContent', 0, '[faqs style="accordion-grouped"]');
                        }
                    },
                    {
                        text: 'FAQs Filterable Toggle',
                        onclick: function() {
                            ed.execCommand('mceInsertContent', 0, '[faqs style="toggle" filter="true"]');
                        }
                    },
                    {
                        text: 'FAQs Filterable Accordion',
                        onclick: function() {
                            ed.execCommand('mceInsertContent', 0, '[faqs style="accordion" filter="true"]');
                        }
                    },
                    {
                        text: 'FAQs Order By Title (ASC)',
                        onclick: function() {
                            ed.execCommand('mceInsertContent', 0, '[faqs order="ASC" orderby="title"]');
                        }
                    },
                    {
                        text: 'FAQs Order By Title (DESC)',
                        onclick: function() {
                            ed.execCommand('mceInsertContent', 0, '[faqs order="DESC" orderby="title"]');
                        }
                    },
                    {
                        text: 'FAQs Toggle Order By Title (ASC)',
                        onclick: function() {
                            ed.execCommand('mceInsertContent', 0, '[faqs style="toggle" order="ASC" orderby="title"]');
                        }
                    },
                    {
                        text: 'FAQs Toggle Order By Title (DESC)',
                        onclick: function() {
                            ed.execCommand('mceInsertContent', 0, '[faqs style="toggle" order="DESC" orderby="title"]');
                        }
                    },
                    {
                        text: 'FAQs Accordion Order By Title (ASC)',
                        onclick: function() {
                            ed.execCommand('mceInsertContent', 0, '[faqs style="accordion" order="ASC" orderby="title"]');
                        }
                    },
                    {
                        text: 'FAQs Accordion Order By Title (DESC)',
                        onclick: function() {
                            ed.execCommand('mceInsertContent', 0, '[faqs style="accordion" order="DESC" orderby="title"]');
                        }
                    }
                ]
            });

        },
    });

    tinymce.PluginManager.add("faqs_button", tinymce.plugins.faqs_button);

    
})();