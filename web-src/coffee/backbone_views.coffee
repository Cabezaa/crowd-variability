# backbone_views.coffee --
# Copyright (C) 2016 Giménez, Christian

# This program is free software: you can redistribute it and/or modify
# it under the terms of the GNU Affero General Public License as published by
# the Free Software Foundation, either version 3 of the License, or
# (at your option) any later version.

# This program is distributed in the hope that it will be useful,
# but WITHOUT ANY WARRANTY; without even the implied warranty of
# MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
# GNU Affero General Public License for more details.

# You should have received a copy of the GNU Affero General Public License
# along with this program.  If not, see <http://www.gnu.org/licenses/>.


TrafficLightsView = Backbone.View.extend(
    initialize: () ->
        this.render()

    render: () ->
        template = _.template($("#template_trafficlight").html(), {})
        this.$el.html(template)

    events:
        "click a#traffic_btn" : "check_satisfiable"
        
    check_satisfiable: (event) ->
        gui.gui_instance.check_satisfiable()

    turn_red: () ->
        this.$el.find("#traffic_img").attr(
            "src",
            "imgs/h-traffic-light-red.svg") 
    turn_green: () ->
        this.$el.find("#traffic_img").attr(
            "src",
            "imgs/h-traffic-light-green.svg") 
    turn_yellow: () ->
        this.$el.find("#traffic_img").attr(
            "src",
            "imgs/h-traffic-light-yellow.svg")
    turn_yellow_flashing: () ->
        this.$el.find("#traffic_img").attr(
            "src",
            "imgs/h-traffic-light-red-flashing.svg") 
    turn_red_flashing: () ->
        this.$el.find("#traffic_img").attr(
            "src",
            "imgs/h-traffic-light-red-flashing.svg") 
    turn_all: () ->        
        this.$el.find("#traffic_img").attr(
            "src",
            "imgs/h-traffic-light.svg") 
        
)

# Provides elements and events needed for displaying the interface for
# creating a new class.
CreateClassView = Backbone.View.extend(    
        initialize: () ->
        	this.render()
    
        render: () ->
            template = _.template( $("#template_tools_navbar").html(), {} )
            this.$el.html(template)

        events: 
        	"click a#crearclase_button" :
                "create_class"
            "click a#translate_button" :
                "translate_owllink"
            "click a#insertowllink_button":
                "insert_owllink"

        create_class: (event) ->
            alert("Creando: " + $("#crearclase_input").val() + "...")
            gui.gui_instance.add_class(
                name: $("#crearclase_input").val()
            )

        # Event handler for translate diagram to OWLlink using Ajax
        # and the api/translate/calvanesse.php translator URL.
        translate_owllink: (event) ->
            gui.gui_instance.translate_owllink()

        # Which is the current translation format selected by the
        # user?
        #
        # @return [String] "html", "owllink", etc.
        get_translation_format: () ->
            $("#format_select")[0].value

        insert_owllink: () ->
            gui.gui_instance.show_insert_owllink()

                
);

EditClassView = Backbone.View.extend(
    initialize: () ->
        this.render()
        this.$el.hide()

    render: () ->
        template = _.template( $("#template_editclass").html())
        this.$el.html(template({classid: @classid}))

    events:
        "click a#editclass_button" : "edit_class"
        "click a#close_button" : "hide"

    # Set this class ID and position the form onto the
    # 
    # Class diagram.
    set_classid : (@classid) ->
        viewpos = graph.getCell(@classid).findView(paper).getBBox()

        this.$el.css(
            top: viewpos.y,
            left: viewpos.x,
            position: 'absolute',
            'z-index': 1
            )
        this.$el.show()

    get_classid : () ->
        return @classid
    
    edit_class: (event) ->
        name = $("#editclass_input").val()
        gui.gui_instance.edit_class_name(@classid, name)
        # Hide the form.
        gui.gui_instance.hide_options()

    hide: () ->
        this.$el.hide()

)

RelationOptionsView = Backbone.View.extend(
    initialize: () ->
        this.render()
        this.$el.hide()

    render: () ->
        template = _.template( $("#template_relationoptions").html() )
        this.$el.html(template({classid: @classid}))

    events:
        'click a#association_button' : 'new_relation',
        'click a#isa_button' : 'new_isa'

    new_relation: () ->
        gui.gui_instance.set_association_state(@classid)

    new_isa: () ->
        gui.gui_instance.set_isa_state(@classid)

    set_classid: (@classid) ->
        viewpos = graph.getCell(@classid).findView(paper).getBBox()

        this.$el.css(
            top: viewpos.y,
            left: viewpos.x + viewpos.width,
            position: 'absolute',
            'z-index': 1
            )
        this.$el.show()
        
    get_classid: () ->
        return @classid

    hide: () ->
        this.$el.hide()
)

ClassOptionsView = Backbone.View.extend(
    initialize: () ->
        this.render()
        this.$el.hide()

    render: () ->
        template = _.template( $("#template_classoptions").html() )
        this.$el.html(template({classid: @classid}))

    events:
        "click a#deleteclass_button" : "delete_class",
        "click a#editclass_button" : "edit_class"

    ##
    # Set the classid of the Joint Model associated to this EditClass
    # instance, then set the position of the template to where is the
    # class Joint Model.
    set_classid: (@classid) ->
        viewpos = graph.getCell(@classid).findView(paper).getBBox()

        this.$el.css(
            top: viewpos.y,
            left: viewpos.x,
            position: 'absolute',
            'z-index': 1
            )
        this.$el.show()

    ##
    # Return the ClassID of the Joint.Model element associated to
    # this EditClass instance. 
    get_classid: () ->
        return @classid
        
    delete_class: (event) ->
        gui.gui_instance.hide_options()
        gui.gui_instance.delete_class(@classid)

    edit_class: (event) ->
        gui.gui_instance.hide_options()
        gui.gui_instance.set_editclass_classid(@classid)
        this.hide()

    hide: () ->
        this.$el.hide()
)

##
# A view for inserting and editing OWLlink text.
OWLlinkInsertView = Backbone.View.extend(
    initialize: () ->
        this.render()
        @textarea = this.$el.find("#insert_owllink_input")
        
    render: () ->
        template = _.template( $("#template_insertowllink").html() )
        this.$el.html( template() )

    events:
        "click a#insert_owlclass" : "insert_class"

    get_owllink: () ->
        return @textarea[0].value
        
    set_owllink: (str) ->
        @textarea[0].value = str

    append_owllink: (str) ->
        @textarea[0].value = @textarea[0].value + str

    insert_class: () ->
        this.append_owllink("<owl:Class IRI=\"CLASSNAME\" />")
)

ErrorWidgetView = Backbone.View.extend(
    initialize: () ->
        this.render()
        # We need to initialize the error-popup div because
        # jquery-mobile.js script is loaded before this script.
        this.$el.find(".error-popup").popup()
        #this.$el.hide()
    render: () ->
        template = _.template( $("#template_errorwidget").html() )
        this.$el.html( template() )
    show: (status, message) ->
        $(".error-popup").popup("open")
        $("#errorstatus_text").html(status)
        $("#errormsg_text").html(message)
        console.log(status + " - " + message)
    events:
        "click a#errorwidget_hide_btn" : "hide"
    hide: () ->
        $(".error-popup").popup("close")
)

exports = exports ? this
exports.CreateClassView = CreateClassView
exports.EditClassView = EditClassView
exports.ClassOptionsView = ClassOptionsView
exports.RelationOptionsView = RelationOptionsView
exports.TrafficLightsView = TrafficLightsView
exports.OWLlinkInsertView = OWLlinkInsertView
exports.ErrorWidgetView = ErrorWidgetView
