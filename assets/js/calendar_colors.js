/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

$(document).ready(function() {

    var colors = ['#ff0000', '#00ff00', '#0000ff'];
    var random_color = colors[Math.floor(Math.random() * colors.length)];
    var elems = document.getElementsByClassName('calendar-category13');

   for(var i=0; i<elems.length; i++)
                {
                    elems[i].setAttribute('style', 'background: ' + colors[i%3]);
                }
//todo Username auf Zahl mappen und ins html schreiben oder anders verwendenum eindeutige farbe zu bestimmen
//$('.calendar-category13').css('background-color', random_color);

elems[0].onmouseover = handler;

function handler(event) {
  event.target.style.backgroundColor = 'yellow';
}

});
    