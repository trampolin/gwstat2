<?php
/**
 * Created by PhpStorm.
 * User: rmahr1
 * Date: 29.08.15
 * Time: 10:10
 */

class PlanetModel extends CI_Model
{
    public function parseHtml($html) {
        $regex = '/<tr class="[a-z ]*">\s+<td>[\d]+<.td>\s+<td>(.+)<.td>\s*<td>\s*<a href="http:\/\/([a-zA-Z0-9]+)\.gigrawars\.de\/playerInfo\/([\d]+)\/([\d]+):([\d]+):([\d]+)\/">(.+)<\/a>\s+<\/td>\s+<td>(<a href="http:\/\/[a-zA-Z0-9]+\.gigrawars\.de\/alliance\/([\d]+)\/">\[([\S]+)\]<\/a>|(-))<\/td>\s+<td>[\d]+<\/td>\s+<td>.*<\/td>/';
        $matches = [];
        preg_match_all($regex,$html,$matches);

        var_dump($matches);
    }
}