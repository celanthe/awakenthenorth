YUI.add("moodle-course-coursebase",function(e,t){var n="course-coursebase",r=function(){r.superclass.constructor.apply(this,arguments)};e.extend(r,e.Base,{registermodules:[],register_module:function(e){return this.registermodules.push(e),this},invoke_function:function(e,t){var n;for(n in this.registermodules)e in this.registermodules[n]&&this.registermodules[n][e](t);return this}},{NAME:n,ATTRS:{}}),M.course=M.course||{},M.course.coursebase=M.course.coursebase||new r,M.course.format=M.course.format||{},M.course.format.swap_sections=M.course.format.swap_sections||function(){return null},M.course.format.process_sections=M.course.format.process_sections||function(){return null},M.course.format.get_config=M.course.format.get_config||function(){return{container_node:null,container_class:null,section_wrapper_node:null,section_wrapper_class:null,section_node:null,section_class:null}},M.course.format.get_section_selector=M.course.format.get_section_selector||function(){var e=M.course.format.get_config();return e.section_node&&e.section_class?e.section_node+"."+e.section_class:null},M.course.format.get_section_wrapper=M.course.format.get_section_wrapper||function(e){var t=M.course.format.get_config();return t.section_wrapper_node&&t.section_wrapper_class?t.section_wrapper_node+"."+t.section_wrapper_class:M.course.format.get_section_selector(e)},M.course.format.get_containernode=M.course.format.get_containernode||function(){var e=M.course.format.get_config();if(e.container_node)return e.container_node},M.course.format.get_containerclass=M.course.format.get_containerclass||function(){var e=M.course.format.get_config();if(e.container_class)return e.container_class},M.course.format.get_sectionwrappernode=M.course.format.get_sectionwrappernode||function(){var e=M.course.format.get_config();return e.section_wrapper_node?e.section_wrapper_node:e.section_node},M.course.format.get_sectionwrapperclass=M.course.format.get_sectionwrapperclass||function(){var e=M.course.format.get_config();return e.section_wrapper_class?e.section_wrapper_class:e.section_class},M.course.format.get_sectionnode=M.course.format.get_sectionnode||function(){var e=M.course.format.get_config();if(e.section_node)return e.section_node},M.course.format.get_sectionclass=M.course.format.get_sectionclass||function(){var e=M.course.format.get_config();if(e.section_class)return e.section_class}},"@VERSION@",{requires:["base","node"]});
