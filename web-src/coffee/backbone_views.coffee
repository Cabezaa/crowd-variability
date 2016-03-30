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
        guiinst.check_satisfiable()
        
)

##
# CrearClaseView proporciona los elementos y eventos necesarios
#   para mostra una interfaz para crear una clase.
CrearClaseView = Backbone.View.extend(    
        initialize: () ->
        	this.render()
    
        render: () ->
            template = _.template( $("#template_crearclase").html(), {} )
            this.$el.html(template)

        events: 
        	"click a#crearclase_button" :
                        "crear_clase"
            "click a#translate_button" :
                        "translate_owllink"

        crear_clase: (event) ->
            alert("Creando: " + $("#crearclase_input").val() + "...")
            nueva = new Class($("#crearclase_input").val(), [], [])
            guiinst.add_class(nueva)

        ##
        # Event handler for translate diagram to OWLlink using Ajax
        # and the translator/calvanesse.php translator URL.
        translate_owllink: (event) ->
            guiinst.translate_owllink()


                
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
        guiinst.edit_class(@classid)
        # Hide the form.
        guiinst.hide_options()

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

    events: () ->

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
        guiinst.hide_options()
        guiinst.delete_class(@classid)

    edit_class: (event) ->
        guiinst.hide_options()
        guiinst.set_editclass_classid(@classid)
        this.hide()

    hide: () ->
        this.$el.hide()
)


exports = exports ? this
exports.CrearClaseView = CrearClaseView
exports.EditClassView = EditClassView
exports.ClassOptionsView = ClassOptionsView
exports.RelationOptionsView = RelationOptionsView
exports.TrafficLightsView = TrafficLightsView