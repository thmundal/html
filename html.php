<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

function html($tagname, $content = "", $attributes = [], $single_element = false) {
    $html = '<'.$tagname;
    
    if(sizeof($attributes) > 0) {
        $attr_string = '';
        foreach($attributes as $key => $val) {
            if($key == "style" AND is_array($val)) {
                $stylestring = "";
                foreach($val as $k => $v) {
                    $stylestring .= $k.':'.$v.';';
                }
                $val = $stylestring;
            }            
            $attr_string .= $key.'="'.$val.'" ';
        }
        $html .= " ".$attr_string;
    }
    
    if(!$single_element)
        $html .='>'.$content.'</'.$tagname.'>';
    else
        $html .= ' />';
    
    return $html;
}

function img($src, $attributes = []) {
    $attributes["src"] = $src;
    return html("img", "", $attributes, true);
}

function table(array $tabledata, array $attributes = []) {
    $html = "<table";
    if(sizeof($attributes) > 0) {
        $attr_string = '';
        foreach($attributes as $key => $val) {
            if($key == "style" AND is_array($val)) {
                $stylestring = "";
                foreach($val as $k => $v) {
                    $stylestring .= $k.':'.$v.';';
                }
                $val = $stylestring;
            }            
            $attr_string .= $key.'="'.$val.'" ';
        }
        $html .= " ".$attr_string;
    }
    $html .= ">";
    
    foreach($tabledata as $tr) {                
        $html .= html("tr", call(function() use($tr){
            $html = "";
            foreach($tr as $td) {
                $html .= html("td",arrGet($td, "content", ""),arrGet($td, "attributes", []));
            }
            return $html;
        }));
    }
    $html .= "</table>";
    
    return $html;
}

function form(Array $attributes, Array $formdata) {
    return html("form", call(function() use($formdata) {
        $htmlstring = "";
        foreach($formdata as $element => $attributes) {
            if($element == "textarea") {
                $htmlstring .= html("textarea", arrGet($attributes, "content", ""), $attributes);
                continue;
            } else {
                $htmlstring .= html($element, "", $attributes, TRUE);
            }
            return $htmlstring;
        }
    }), $attributes);
}

function input($type, Array $attributes = [], $content = "") {
    if($type == "textarea")
        return html($type, arrGet($attributes, "value", $content), $attributes);
    
    return html("input", "", array_merge($attributes, ["type" => $type]), true);
}


function div($content, Array $attributes = []) {
    return html("div", $content, $attributes);
}
?>