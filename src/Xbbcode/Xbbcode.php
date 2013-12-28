<?php

/******************************************************************************
 *                                                                            *
 *   bbcode.lib.php, v 0.29 2007/07/18 - This is part of xBB library          *
 *   Copyright (C) 2006-2007  Dmitriy Skorobogatov  dima@pc.uz                *
 *                                                                            *
 *   This program is free software; you can redistribute it and/or modify     *
 *   it under the terms of the GNU General Public License as published by     *
 *   the Free Software Foundation; either version 2 of the License, or        *
 *   (at your option) any later version.                                      *
 *                                                                            *
 *   This program is distributed in the hope that it will be useful,          *
 *   but WITHOUT ANY WARRANTY; without even the implied warranty of           *
 *   MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the            *
 *   GNU General Public License for more details.                             *
 *                                                                            *
 *   You should have received a copy of the GNU General Public License        *
 *   along with this program; if not, write to the Free Software              *
 *   Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA 02110-1301 USA *
 *                                                                            *
 ******************************************************************************/

namespace Xbbcode;

class Xbbcode
{
    /**
     * Имя тега, которому сопоставлен экземпляр класса.
     * Пустая строка, если экземпляр не сопоставлен никакому тегу.
     */
    public $tag = '';
    /**
     * Массив значений атрибутов тега, которому сопоставлен экземпляр класса.
     * Пуст, если экземпляр не сопоставлен никакому тегу.
     */
    public $attrib = array();
    /**
     * Задаёт возможность наличия у последнего атрибута у тега значений без необходимости наличия кавычек для значений с пробелами.
     * Пример: [altfont=Comic Sans MS]sometext[/altfont] или [altfont size="22" font=Comic Sans MS]sometext[/altfont]
     * По умолчанию выключено
     */
    public $oneattrib = false;
    /**
     * Текст BBCode
     */
    public $text = '';
    /**
     * Массив, - результат синтаксического разбора текста BBCode. Описание смотрите в документации.
     */
    public $syntax = array();
    /**
     * Дерево семантического разбора текста BBCode. Описание смотрите в документации.
     */
    public $tree = array();
    /**
     * Список поддерживаемых тегов с указанием специализированных классов.
     */
    public $tags = array(
        // Основные теги
        '*'            => 'Xbbcode\Tag\Li'     ,
        'a'            => 'Xbbcode\Tag\A'      ,
        'abbr'         => 'Xbbcode\Tag\Abbr'   ,
        'acronym'      => 'Xbbcode\Tag\Acronym',
        'address'      => 'Xbbcode\Tag\Address',
        'align'        => 'Xbbcode\Tag\Align'  ,
        'anchor'       => 'Xbbcode\Tag\A'      ,
        'b'            => 'Xbbcode\Tag\Simple' ,
        'bbcode'       => 'Xbbcode\Tag\Bbcode' ,
        'bdo'          => 'Xbbcode\Tag\Bdo'    ,
        'big'          => 'Xbbcode\Tag\Simple' ,
        'blockquote'   => 'Xbbcode\Tag\Quote'  ,
        'br'           => 'Xbbcode\Tag\Br'     ,
        'caption'      => 'Xbbcode\Tag\Caption',
        'center'       => 'Xbbcode\Tag\Align'  ,
        'cite'         => 'Xbbcode\Tag\Simple' ,
        'color'        => 'Xbbcode\Tag\Color'  ,
        'del'          => 'Xbbcode\Tag\Simple' ,
        'em'           => 'Xbbcode\Tag\Simple' ,
        'email'        => 'Xbbcode\Tag\Email'  ,
        'font'         => 'Xbbcode\Tag\Font'   ,
        'altfont'      => 'Xbbcode\Tag\Altfont',
        'google'       => 'Xbbcode\Tag\Google' ,
        'h1'           => 'Xbbcode\Tag\P'      ,
        'h2'           => 'Xbbcode\Tag\P'      ,
        'h3'           => 'Xbbcode\Tag\P'      ,
        'h4'           => 'Xbbcode\Tag\P'      ,
        'h5'           => 'Xbbcode\Tag\P'      ,
        'h6'           => 'Xbbcode\Tag\P'      ,
        'hr'           => 'Xbbcode\Tag\Hr'     ,
        'i'            => 'Xbbcode\Tag\Simple' ,
        'img'          => 'Xbbcode\Tag\Img'    ,
        'ins'          => 'Xbbcode\Tag\Simple' ,
        'justify'      => 'Xbbcode\Tag\Align'  ,
        'left'         => 'Xbbcode\Tag\Align'  ,
        'list'         => 'Xbbcode\Tag\Ul'     ,
        'nobb'         => 'Xbbcode\Tag\Nobb'   ,
        'ol'           => 'Xbbcode\Tag\Ul'     ,
        'p'            => 'Xbbcode\Tag\P'      ,
        'quote'        => 'Xbbcode\Tag\Quote'  ,
        'right'        => 'Xbbcode\Tag\Align'  ,
        's'            => 'Xbbcode\Tag\Simple' ,
        'size'         => 'Xbbcode\Tag\Size'   ,
        'small'        => 'Xbbcode\Tag\Simple' ,
        'strike'       => 'Xbbcode\Tag\Simple' ,
        'strong'       => 'Xbbcode\Tag\Simple' ,
        'sub'          => 'Xbbcode\Tag\Simple' ,
        'sup'          => 'Xbbcode\Tag\Simple' ,
        'table'        => 'Xbbcode\Tag\Table'  ,
        'td'           => 'Xbbcode\Tag\Td'     ,
        'th'           => 'Xbbcode\Tag\Th'     ,
        'tr'           => 'Xbbcode\Tag\Tr'     ,
        'tt'           => 'Xbbcode\Tag\Simple' ,
        'u'            => 'Xbbcode\Tag\Simple' ,
        'ul'           => 'Xbbcode\Tag\Ul'     ,
        'url'          => 'Xbbcode\Tag\A'      ,
        'var'          => 'Xbbcode\Tag\Simple' ,

        // Теги для вывода кода и подсветки синтаксисов (с помощью GeSHi)
        '4cs'               => 'Xbbcode\Tag\Code'   ,
        '6502acme'          => 'Xbbcode\Tag\Code'   ,
        '6502kickass'       => 'Xbbcode\Tag\Code'   ,
        '6502tasm'          => 'Xbbcode\Tag\Code'   ,
        '68000devpac'       => 'Xbbcode\Tag\Code'   ,
        'abap'              => 'Xbbcode\Tag\Code'   ,
        'actionscript'      => 'Xbbcode\Tag\Code'   ,
        'actionscript3'     => 'Xbbcode\Tag\Code'   ,
        'ada'               => 'Xbbcode\Tag\Code'   ,
        'algol'             => 'Xbbcode\Tag\Code'   ,
        'apache'            => 'Xbbcode\Tag\Code'   ,
        'applescript'       => 'Xbbcode\Tag\Code'   ,
        'apt_sources'       => 'Xbbcode\Tag\Code'   ,
        'arm'               => 'Xbbcode\Tag\Code'   ,
        'asm'               => 'Xbbcode\Tag\Code'   ,
        'asp'               => 'Xbbcode\Tag\Code'   ,
        'asymptote'         => 'Xbbcode\Tag\Code'   ,
        'autoconf'          => 'Xbbcode\Tag\Code'   ,
        'autohotkey'        => 'Xbbcode\Tag\Code'   ,
        'autoit'            => 'Xbbcode\Tag\Code'   ,
        'avisynth'          => 'Xbbcode\Tag\Code'   ,
        'awk'               => 'Xbbcode\Tag\Code'   ,
        'bascomavr'         => 'Xbbcode\Tag\Code'   ,
        'bash'              => 'Xbbcode\Tag\Code'   ,
        'basic4gl'          => 'Xbbcode\Tag\Code'   ,
        'bf'                => 'Xbbcode\Tag\Code'   ,
        'bibtex'            => 'Xbbcode\Tag\Code'   ,
        'blitzbasic'        => 'Xbbcode\Tag\Code'   ,
        'bnf'               => 'Xbbcode\Tag\Code'   ,
        'boo'               => 'Xbbcode\Tag\Code'   ,
        'c'                 => 'Xbbcode\Tag\Code'   ,
        'c++'               => 'Xbbcode\Tag\Code'   ,
        'c#'                => 'Xbbcode\Tag\Code'   ,
        'c_loadrunner'      => 'Xbbcode\Tag\Code'   ,
        'c_mac'             => 'Xbbcode\Tag\Code'   ,
        'caddcl'            => 'Xbbcode\Tag\Code'   ,
        'cadlisp'           => 'Xbbcode\Tag\Code'   ,
        'cfdg'              => 'Xbbcode\Tag\Code'   ,
        'cfm'               => 'Xbbcode\Tag\Code'   ,
        'chaiscript'        => 'Xbbcode\Tag\Code'   ,
        'cil'               => 'Xbbcode\Tag\Code'   ,
        'clojure'           => 'Xbbcode\Tag\Code'   ,
        'cmake'             => 'Xbbcode\Tag\Code'   ,
        'cobol'             => 'Xbbcode\Tag\Code'   ,
        'code'              => 'Xbbcode\Tag\Code'   ,
        'coffeescript'      => 'Xbbcode\Tag\Code'   ,
        'cpp-qt'            => 'Xbbcode\Tag\Code'   ,
        'css'               => 'Xbbcode\Tag\Code'   ,
        'cuesheet'          => 'Xbbcode\Tag\Code'   ,
        'd'                 => 'Xbbcode\Tag\Code'   ,
        'dcl'               => 'Xbbcode\Tag\Code'   ,
        'dcpu16'            => 'Xbbcode\Tag\Code'   ,
        'dcs'               => 'Xbbcode\Tag\Code'   ,
        'delphi'            => 'Xbbcode\Tag\Code'   ,
        'diff'              => 'Xbbcode\Tag\Code'   ,
        'div'               => 'Xbbcode\Tag\Code'   ,
        'dos'               => 'Xbbcode\Tag\Code'   ,
        'e'                 => 'Xbbcode\Tag\Code'   ,
        'ecmascript'        => 'Xbbcode\Tag\Code'   ,
        'eiffel'            => 'Xbbcode\Tag\Code'   ,
        'epc'               => 'Xbbcode\Tag\Code'   ,
        'erlang'            => 'Xbbcode\Tag\Code'   ,
        'euphoria'          => 'Xbbcode\Tag\Code'   ,
        'f++'               => 'Xbbcode\Tag\Code'   ,
        'f#'                => 'Xbbcode\Tag\Code'   ,
        'f1'                => 'Xbbcode\Tag\Code'   ,
        'falcon'            => 'Xbbcode\Tag\Code'   ,
        'fo'                => 'Xbbcode\Tag\Code'   ,
        'fortran'           => 'Xbbcode\Tag\Code'   ,
        'freebasic'         => 'Xbbcode\Tag\Code'   ,
        'freeswitch'        => 'Xbbcode\Tag\Code'   ,
        'gambas'            => 'Xbbcode\Tag\Code'   ,
        'gdb'               => 'Xbbcode\Tag\Code'   ,
        'genero'            => 'Xbbcode\Tag\Code'   ,
        'genie'             => 'Xbbcode\Tag\Code'   ,
        'gettext'           => 'Xbbcode\Tag\Code'   ,
        'glsl'              => 'Xbbcode\Tag\Code'   ,
        'gml'               => 'Xbbcode\Tag\Code'   ,
        'gnuplot'           => 'Xbbcode\Tag\Code'   ,
        'go'                => 'Xbbcode\Tag\Code'   ,
        'groovy'            => 'Xbbcode\Tag\Code'   ,
        'gwbasic'           => 'Xbbcode\Tag\Code'   ,
        'haskell'           => 'Xbbcode\Tag\Code'   ,
        'haxe'              => 'Xbbcode\Tag\Code'   ,
        'hicest'            => 'Xbbcode\Tag\Code'   ,
        'hq9plus'           => 'Xbbcode\Tag\Code'   ,
        'html4'             => 'Xbbcode\Tag\Code'   ,
        'html5'             => 'Xbbcode\Tag\Code'   ,
        'icon'              => 'Xbbcode\Tag\Code'   ,
        'idl'               => 'Xbbcode\Tag\Code'   ,
        'ini'               => 'Xbbcode\Tag\Code'   ,
        'inno'              => 'Xbbcode\Tag\Code'   ,
        'intercal'          => 'Xbbcode\Tag\Code'   ,
        'io'                => 'Xbbcode\Tag\Code'   ,
        'j'                 => 'Xbbcode\Tag\Code'   ,
        'java'              => 'Xbbcode\Tag\Code'   ,
        'java5'             => 'Xbbcode\Tag\Code'   ,
        'jquery'            => 'Xbbcode\Tag\Code'   ,
        'js'                => 'Xbbcode\Tag\Code'   ,
        'kixtart'           => 'Xbbcode\Tag\Code'   ,
        'klonec'            => 'Xbbcode\Tag\Code'   ,
        'klonecpp'          => 'Xbbcode\Tag\Code'   ,
        'latex'             => 'Xbbcode\Tag\Code'   ,
        'lb'                => 'Xbbcode\Tag\Code'   ,
        'ldif'              => 'Xbbcode\Tag\Code'   ,
        'lisp'              => 'Xbbcode\Tag\Code'   ,
        'llvm'              => 'Xbbcode\Tag\Code'   ,
        'locobasic'         => 'Xbbcode\Tag\Code'   ,
        'logtalk'           => 'Xbbcode\Tag\Code'   ,
        'lolcode'           => 'Xbbcode\Tag\Code'   ,
        'lotusformulas'     => 'Xbbcode\Tag\Code'   ,
        'lotusscript'       => 'Xbbcode\Tag\Code'   ,
        'lscript'           => 'Xbbcode\Tag\Code'   ,
        'lsl2'              => 'Xbbcode\Tag\Code'   ,
        'lua'               => 'Xbbcode\Tag\Code'   ,
        'm68k'              => 'Xbbcode\Tag\Code'   ,
        'magiksf'           => 'Xbbcode\Tag\Code'   ,
        'make'              => 'Xbbcode\Tag\Code'   ,
        'mapbasic'          => 'Xbbcode\Tag\Code'   ,
        'matlab'            => 'Xbbcode\Tag\Code'   ,
        'mirc'              => 'Xbbcode\Tag\Code'   ,
        'mmix'              => 'Xbbcode\Tag\Code'   ,
        'modula2'           => 'Xbbcode\Tag\Code'   ,
        'modula3'           => 'Xbbcode\Tag\Code'   ,
        'mpasm'             => 'Xbbcode\Tag\Code'   ,
        'mxml'              => 'Xbbcode\Tag\Code'   ,
        'mysql'             => 'Xbbcode\Tag\Code'   ,
        'nagios'            => 'Xbbcode\Tag\Code'   ,
        'netrexx'           => 'Xbbcode\Tag\Code'   ,
        'newlisp'           => 'Xbbcode\Tag\Code'   ,
        'nsis'              => 'Xbbcode\Tag\Code'   ,
        'oberon2'           => 'Xbbcode\Tag\Code'   ,
        'objc'              => 'Xbbcode\Tag\Code'   ,
        'objeck'            => 'Xbbcode\Tag\Code'   ,
        'ocaml'             => 'Xbbcode\Tag\Code'   ,
        'octave'            => 'Xbbcode\Tag\Code'   ,
        'oobas'             => 'Xbbcode\Tag\Code'   ,
        'oorexx'            => 'Xbbcode\Tag\Code'   ,
        'oracle'            => 'Xbbcode\Tag\Code'   ,
        'oracle11'          => 'Xbbcode\Tag\Code'   ,
        'oxygene'           => 'Xbbcode\Tag\Code'   ,
        'oz'                => 'Xbbcode\Tag\Code'   ,
        'parasail'          => 'Xbbcode\Tag\Code'   ,
        'parigp'            => 'Xbbcode\Tag\Code'   ,
        'pascal'            => 'Xbbcode\Tag\Code'   ,
        'pcre'              => 'Xbbcode\Tag\Code'   ,
        'per'               => 'Xbbcode\Tag\Code'   ,
        'perl'              => 'Xbbcode\Tag\Code'   ,
        'perl6'             => 'Xbbcode\Tag\Code'   ,
        'pf'                => 'Xbbcode\Tag\Code'   ,
        'php'               => 'Xbbcode\Tag\Code'   ,
        'pic16'             => 'Xbbcode\Tag\Code'   ,
        'pike'              => 'Xbbcode\Tag\Code'   ,
        'pixelbender'       => 'Xbbcode\Tag\Code'   ,
        'pli'               => 'Xbbcode\Tag\Code'   ,
        'plsql'             => 'Xbbcode\Tag\Code'   ,
        'postgresql'        => 'Xbbcode\Tag\Code'   ,
        'povray'            => 'Xbbcode\Tag\Code'   ,
        'powershell'        => 'Xbbcode\Tag\Code'   ,
        'pre'               => 'Xbbcode\Tag\Code'   ,
        'proftpd'           => 'Xbbcode\Tag\Code'   ,
        'progress'          => 'Xbbcode\Tag\Code'   ,
        'prolog'            => 'Xbbcode\Tag\Code'   ,
        'properties'        => 'Xbbcode\Tag\Code'   ,
        'providex'          => 'Xbbcode\Tag\Code'   ,
        'purebasic'         => 'Xbbcode\Tag\Code'   ,
        'pycon'             => 'Xbbcode\Tag\Code'   ,
        'pys60'             => 'Xbbcode\Tag\Code'   ,
        'python'            => 'Xbbcode\Tag\Code'   ,
        'q'                 => 'Xbbcode\Tag\Code'   ,
        'qbasic'            => 'Xbbcode\Tag\Code'   ,
        'rails'             => 'Xbbcode\Tag\Code'   ,
        'rebol'             => 'Xbbcode\Tag\Code'   ,
        'reg'               => 'Xbbcode\Tag\Code'   ,
        'rexx'              => 'Xbbcode\Tag\Code'   ,
        'robots'            => 'Xbbcode\Tag\Code'   ,
        'rpmspec'           => 'Xbbcode\Tag\Code'   ,
        'rsplus'            => 'Xbbcode\Tag\Code'   ,
        'ruby'              => 'Xbbcode\Tag\Code'   ,
        'sas'               => 'Xbbcode\Tag\Code'   ,
        'scala'             => 'Xbbcode\Tag\Code'   ,
        'scheme'            => 'Xbbcode\Tag\Code'   ,
        'scilab'            => 'Xbbcode\Tag\Code'   ,
        'sdlbasic'          => 'Xbbcode\Tag\Code'   ,
        'smalltalk'         => 'Xbbcode\Tag\Code'   ,
        'smarty'            => 'Xbbcode\Tag\Code'   ,
        'spark'             => 'Xbbcode\Tag\Code'   ,
        'sparql'            => 'Xbbcode\Tag\Code'   ,
        'sql'               => 'Xbbcode\Tag\Code'   ,
        'stonescript'       => 'Xbbcode\Tag\Code'   ,
        'systemverilog'     => 'Xbbcode\Tag\Code'   ,
        't-sql'             => 'Xbbcode\Tag\Code'   ,
        'tcl'               => 'Xbbcode\Tag\Code'   ,
        'teraterm'          => 'Xbbcode\Tag\Code'   ,
        'text'              => 'Xbbcode\Tag\Code'   ,
        'thinbasic'         => 'Xbbcode\Tag\Code'   ,
        'twig'              => 'Xbbcode\Tag\Code'   ,
        'typoscript'        => 'Xbbcode\Tag\Code'   ,
        'unicon'            => 'Xbbcode\Tag\Code'   ,
        'upc'               => 'Xbbcode\Tag\Code'   ,
        'urbi'              => 'Xbbcode\Tag\Code'   ,
        'uscript'           => 'Xbbcode\Tag\Code'   ,
        'vala'              => 'Xbbcode\Tag\Code'   ,
        'vb'                => 'Xbbcode\Tag\Code'   ,
        'vb.net'            => 'Xbbcode\Tag\Code'   ,
        'vedit'             => 'Xbbcode\Tag\Code'   ,
        'verilog'           => 'Xbbcode\Tag\Code'   ,
        'vhdl'              => 'Xbbcode\Tag\Code'   ,
        'vim'               => 'Xbbcode\Tag\Code'   ,
        'visualfoxpro'      => 'Xbbcode\Tag\Code'   ,
        'visualprolog'      => 'Xbbcode\Tag\Code'   ,
        'whitespace'        => 'Xbbcode\Tag\Code'   ,
        'whois'             => 'Xbbcode\Tag\Code'   ,
        'winbatch'          => 'Xbbcode\Tag\Code'   ,
        'xbasic'            => 'Xbbcode\Tag\Code'   ,
        'xml'               => 'Xbbcode\Tag\Code'   ,
        'xorg_conf'         => 'Xbbcode\Tag\Code'   ,
        'xpp'               => 'Xbbcode\Tag\Code'   ,
        'yaml'              => 'Xbbcode\Tag\Code'   ,
        'z80'               => 'Xbbcode\Tag\Code'   ,
        'zxbasic'           => 'Xbbcode\Tag\Code'   ,
    );
    /**
     * Смайлики и прочие мнемоники. Массив: 'мнемоника' => 'ее_замена'.
     */
    public $mnemonics = array();
    /**
     * Флажок, включающий/выключающий автоматические ссылки.
     */
    public $autolinks = false;
    /**
     * Массив замен для автоматических ссылок.
     */
    public $preg_autolinks = array(
        'pattern' => array(
            "'[\w\+]+://[A-z0-9\.\?\+\-/_=&%#:;]+[\w/=]+'si",
            "'([^/])(www\.[A-z0-9\.\?\+\-/_=&%#:;]+[\w/=]+)'si",
            "'[\w]+[\w\-\.]+@[\w\-\.]+\.[\w]+'si",
        ),
        'replacement' => array(
            '<a href="$0" target="_blank">$0</a>',
            '$1<a href="http://$2" target="_blank">$2</a>',
            '<a href="mailto:$0">$0</a>',
        ),
        'highlight' => array(
            '<span class="bb_autolink">$0</span>',
            '$1<span class="bb_autolink">$2</span>',
            '<span class="bb_autolink">$0</span>',
        ),
    );
    public $is_close = false;
    public $lbr = 0;
    public $rbr = 0;
    /**
     * Статистические сведения по обработке BBCode
     */
    public $stat = array(
        'time_parse' => 0,  // Время парсинга
        'time_html' => 0,   // Время генерации HTML-а
        'count_tags' => 0,  // Число тегов BBCode
        'count_level' => 0  // Число уровней вложенности тегов BBCode
    );
    /**
     * Модель поведения тега (в плане вложенности), которому сопоставлен экземпляр данного класса.
     * Модели поведения могут быть следующими:
     * 'a'       - ссылки, якоря
     * 'caption' - заголовки таблиц
     * 'code'    - линейные контейнеры кода
     * 'div'     - блочные элементы
     * 'hr'      - горизонтальные линии
     * 'img'     - картинки
     * 'li'      - элементы списков
     * 'p'       - блочные элементы типа абзацев и заголовков
     * 'pre'     - блочные контейнеры кода
     * 'span'    - линейные элементы
     * 'table'   - таблицы
     * 'td'      - ячейки таблиц
     * 'tr'      - строки таблиц
     * 'ul'      - списки
     * Конкретное содержание в понятие "модель поведения" вкладывается настройками
     */
    public $behaviour = 'div';
    /**
     * Публичная WEB директория.
     * Ссылается на директорию resources для формирования смайликов и CSS стилей
     */
    public $web_path = '';
    /**
     * Для нужд парсера. - Позиция очередного обрабатываемого символа.
     */
    private $_cursor;
    /**
     * Массив объектов, - представителей отдельных тегов.
     */
    private $_tag_objects = array();
    /**
     * Массив пар: 'модель_поведения_тегов' => массив_моделей_поведений_тегов.
     * Накладывает ограничения на вложенность тегов.
     * Теги с моделями поведения, не указанными в массиве справа, вложенные в тег с моделью поведения, указанной слева, будут игнорироваться как неправильно вложенные.
     */
    private $_children = array(
        'a'       => array('code','img','span'),
        'caption' => array('a','code','img','span'),
        'code'    => array(),
        'div'     => array('a','code','div','hr','img','p','pre','span','table','ul'),
        'hr'      => array(),
        'img'     => array(),
        'li'      => array('a','code','div','hr','img','p','pre','span','table','ul'),
        'p'       => array('a','code','img','span'),
        'pre'     => array(),
        'span'    => array('a','code','img','span'),
        'table'   => array('caption','tr'),
        'td'      => array('a','code','div','hr','img','p','pre','span','table','ul'),
        'tr'      => array('td'),
        'ul'      => array('li'),
    );
    /**
     * Массив пар: 'модель_поведения_тегов' => массив_моделей_поведений_тегов.
     * Накладывает ограничения на вложенность тегов.
     * Тег, принадлежащий указанной слева модели поведения тегов должен закрыться, как только начинается тег, принадлежащий какой-то из моделей поведения, указанных справа.
     */
    private $_ends = array(
        'a'       => array(
            'a','caption','div','hr','li','p','pre','table','td','tr', 'ul'
        ),
        'caption' => array('tr'),
        'code'    => array(),
        'div'     => array('li','tr','td'),
        'hr'      => array(
            'a','caption','code','div','hr','img','li','p','pre','span','table',
            'td','tr','ul'
        ),
        'img'     => array(
            'a','caption','code','div','hr','img','li','p','pre','span','table',
            'td','tr','ul'
        ),
        'li'      => array('li','tr','td'),
        'p'       => array('div','hr','li','p','pre','table','td','tr','ul'),
        'pre'     => array(),
        'span'    => array('div','hr','li','p','pre','table','td','tr','ul'),
        'table'   => array('table'),
        'td'      => array('td','tr'),
        'tr'      => array('tr'),
        'ul'      => array(),
    );

    /**
     * Конструктор класса
     *
     * @param array|string $code
     * @param array $allowed
     */
    public function __construct ($code, array $allowed = null)
    {
        // Формируем набор смайликов
        $path = $this->web_path . '/resources/images/smiles';
        $pak = file(__DIR__ . '/resources/images/smiles/Set_Smiles_YarNET.pak');
        $smiles = array();
        foreach ($pak as $val) {
            $val = trim($val);
            if ($val && '#' !== $val{0}) {
                list($gif, $alt, $symbol) = explode('=+:', $val);
                $smiles[$symbol] = '<img src="' . $path . '/' . htmlspecialchars($gif) . '" alt="' . htmlspecialchars($alt) . '" />';
            }
        }
        // Задаем набор смайликов
        $this->mnemonics = $smiles;


        // Removing all traces of parsing of disallowed tags. In case if $allowed is not an array, assuming that everything is allowed
        if (is_array($allowed)) {
            foreach ($this->tags as $key => $value) {
                if (!in_array($key, $allowed)) {
                    unset($this->tags[$key]);
                }
            }
        }

        $this->parse($code);
    }


    /**
     * _get_token() - Функция парсит текст BBCode и возвращает очередную пару
     *
     *                     "число (тип лексемы) - лексема"
     *
     * Лексема - подстрока строки $this -> text, начинающаяся с позиции
     * $this -> _cursor
     * Типы лексем могут быть следующие:
     *
     * 0 - открывающая квадратная скобка ("[")
     * 1 - закрывающая квадратная cкобка ("]")
     * 2 - двойная кавычка ('"')
     * 3 - апостроф ("'")
     * 4 - равенство ("=")
     * 5 - прямой слэш ("/")
     * 6 - последовательность пробельных символов
     *    (" ", "\t", "\n", "\r", "\0" или "\x0B")
     * 7 - последовательность прочих символов, не являющаяся именем тега
     * 8 - имя тега
     *
     * @return array|bool
     */
    protected function _get_token()
    {
        $token = '';
        $token_type = false;
        $char_type = false;
        while (true) {
            $token_type = $char_type;
            if (! isset($this -> text{$this -> _cursor})) {
                if (false === $char_type) {
                    return false;
                } else {
                    break;
                }
            }
            $char = $this -> text{$this -> _cursor};
            switch ($char) {
                case '[':
                    $char_type = 0;
                    break;
                case ']':
                    $char_type = 1;
                    break;
                case '"':
                    $char_type = 2;
                    break;
                case "'":
                    $char_type = 3;
                    break;
                case '=':
                    $char_type = 4;
                    break;
                case '/':
                    $char_type = 5;
                    break;
                case ' ':
                    $char_type = 6;
                    break;
                case "\t":
                    $char_type = 6;
                    break;
                case "\n":
                    $char_type = 6;
                    break;
                case "\r":
                    $char_type = 6;
                    break;
                case "\0":
                    $char_type = 6;
                    break;
                case "\x0B":
                    $char_type = 6;
                    break;
                default:
                    $char_type = 7;
                    break;
            }
            if (false === $token_type) {
                $token = $char;
            } elseif (5 >= $token_type) {
                break;
            } elseif ($char_type == $token_type) {
                $token .= $char;
            } else {
                break;
            }
            $this -> _cursor += 1;
        }
        if (isset($this -> tags[strtolower($token)])) {
            $token_type = 8;
        }
        return array($token_type, $token);
    }


    /**
     * Парсер
     *
     * @param array|string $code
     * @return array
     */
    public function parse($code)
    {
        $time_start = $this->_getmicrotime();
        if (is_array($code)) {
            $is_tree = false;
            foreach ($code as $val) {
                if (isset($val['val'])) {
                    $this->tree = $code;
                    $this->syntax = $this->_get_syntax();
                    $is_tree = true;
                    break;
                }
            }
            if (! $is_tree) {
                $this->syntax = $code;
                $this->_get_tree();
            }
            $this->text = '';
            foreach ($this->syntax as $val) {
                $this->text .= $val['str'];
            }
            $this->stat['time_parse'] = $this->_getmicrotime() - $time_start;
            return $this->syntax;
        } else {
            $this->text = $code;
        }
        /*
        Используем метод конечных автоматов
        Список возможных состояний автомата:
        0  - Начало сканирования или находимся вне тега. Ожидаем что угодно.
        1  - Встретили символ "[", который считаем началом тега. Ожидаем имя
             тега, или символ "/".
        2  - Нашли в теге неожидавшийся символ "[". Считаем предыдущую строку
             ошибкой. Ожидаем имя тега, или символ "/".
        3  - Нашли в теге синтаксическую ошибку. Текущий символ не является "[".
             Ожидаем что угодно.
        4  - Сразу после "[" нашли символ "/". Предполагаем, что попали в
             закрывающий тег. Ожидаем имя тега или символ "]".
        5  - Сразу после "[" нашли имя тега. Считаем, что находимся в
             открывающем теге. Ожидаем пробел или "=" или "/" или "]".
        6  - Нашли завершение тега "]". Ожидаем что угодно.
        7  - Сразу после "[/" нашли имя тега. Ожидаем "]".
        8  - В открывающем теге нашли "=". Ожидаем пробел или значение атрибута.
        9  - В открывающем теге нашли "/", означающий закрытие тега. Ожидаем
             "]".
        10 - В открывающем теге нашли пробел после имени тега или имени
             атрибута. Ожидаем "=" или имя другого атрибута или "/" или "]".
        11 - Нашли '"' начинающую значение атрибута, ограниченное кавычками.
             Ожидаем что угодно.
        12 - Нашли "'" начинающий значение атрибута, ограниченное апострофами.
             Ожидаем что угодно.
        13 - Нашли начало незакавыченного значения атрибута. Ожидаем что угодно.
        14 - В открывающем теге после "=" нашли пробел. Ожидаем значение
             атрибута.
        15 - Нашли имя атрибута. Ожидаем пробел или "=" или "/" или "]".
        16 - Находимся внутри значения атрибута, ограниченного кавычками.
             Ожидаем что угодно.
        17 - Завершение значения атрибута. Ожидаем пробел или имя следующего
             атрибута или "/" или "]".
        18 - Находимся внутри значения атрибута, ограниченного апострофами.
             Ожидаем что угодно.
        19 - Находимся внутри незакавыченного значения атрибута. Ожидаем что
             угодно.
        20 - Нашли пробел после значения атрибута. Ожидаем имя следующего
             атрибута или "/" или "]".

        Описание конечного автомата:
        */
        $finite_automaton_orig = array(
               // Предыдущие |   Состояния для текущих событий (лексем)   |
               //  состояния |  0 |  1 |  2 |  3 |  4 |  5 |  6 |  7 |  8 |
                   0 => array(  1 ,  0 ,  0 ,  0 ,  0 ,  0 ,  0 ,  0 ,  0 )
                ,  1 => array(  2 ,  3 ,  3 ,  3 ,  3 ,  4 ,  3 ,  3 ,  5 )
                ,  2 => array(  2 ,  3 ,  3 ,  3 ,  3 ,  4 ,  3 ,  3 ,  5 )
                ,  3 => array(  1 ,  0 ,  0 ,  0 ,  0 ,  0 ,  0 ,  0 ,  0 )
                ,  4 => array(  2 ,  6 ,  3 ,  3 ,  3 ,  3 ,  3 ,  3 ,  7 )
                ,  5 => array(  2 ,  6 ,  3 ,  3 ,  8 ,  9 , 10 ,  3 ,  3 )
                ,  6 => array(  1 ,  0 ,  0 ,  0 ,  0 ,  0 ,  0 ,  0 ,  0 )
                ,  7 => array(  2 ,  6 ,  3 ,  3 ,  3 ,  3 ,  3 ,  3 ,  3 )
                ,  8 => array( 13 , 13 , 11 , 12 , 13 , 13 , 14 , 13 , 13 )
                ,  9 => array(  2 ,  6 ,  3 ,  3 ,  3 ,  3 ,  3 ,  3 ,  3 )
                , 10 => array(  2 ,  6 ,  3 ,  3 ,  8 ,  9 ,  3 , 15 , 15 )
                , 11 => array( 16 , 16 , 17 , 16 , 16 , 16 , 16 , 16 , 16 )
                , 12 => array( 18 , 18 , 18 , 17 , 18 , 18 , 18 , 18 , 18 )
                , 13 => array( 19 ,  6 , 19 , 19 , 19 , 19 , 17 , 19 , 19 )
                , 14 => array(  2 ,  3 , 11 , 12 , 13 , 13 ,  3 , 13 , 13 )
                , 15 => array(  2 ,  6 ,  3 ,  3 ,  8 ,  9 , 10 ,  3 ,  3 )
                , 16 => array( 16 , 16 , 17 , 16 , 16 , 16 , 16 , 16 , 16 )
                , 17 => array(  2 ,  6 ,  3 ,  3 ,  3 ,  9 , 20 , 15 , 15 )
                , 18 => array( 18 , 18 , 18 , 17 , 18 , 18 , 18 , 18 , 18 )
                , 19 => array( 19 ,  6 , 19 , 19 , 19 , 19 , 20 , 19 , 19 )
                , 20 => array(  2 ,  6 ,  3 ,  3 ,  3 ,  9 ,  3 , 15 , 15 )
            );
        // Закончили описание конечного автомата
        $finite_automaton = $finite_automaton_orig;
        $mode = 0;
        $this->syntax = array();
        $decomposition = array();
        $token_key = -1;
        $value = '';
        $name = '';
        $type = false;
        $this ->_cursor = 0;
        $oneattrib_set = false;
        $spacesave = '';
        // Сканируем массив лексем с помощью построенного автомата:
        while ($token = $this -> _get_token()) {
            $previous_mode = $mode;
            $mode = $finite_automaton[$previous_mode][$token[0]];
            if (-1 < $token_key) {
                $type = $this -> syntax[$token_key]['type'];
            } else {
                $type = false;
            }
            switch ($mode) {
            case 0:
                if ('text' === $type) {
                    $this -> syntax[$token_key]['str'] .= $token[1];
                } else {
                    $this -> syntax[++$token_key] = array(
                            'type' => 'text',
                            'str' => $token[1]
                        );
                }
                break;
            case 1:
                $decomposition = array(
                    'name'   => '',
                    'type'   => '',
                    'str'    => '[',
                    'layout' => array(array(0, '['))
                );
                break;
            case 2:
                if ('text' === $type) {
                    $this -> syntax[$token_key]['str'] .= $decomposition['str'];
                } else {
                    $this -> syntax[++$token_key] = array(
                        'type' => 'text',
                        'str' => $decomposition['str']
                    );
                }
                $decomposition = array(
                    'name'   => '',
                    'type'   => '',
                    'str'    => '[',
                    'layout' => array(array(0, '['))
                );
                break;
            case 3:
                if ('text' === $type) {
                    $this -> syntax[$token_key]['str'] .= $decomposition['str'];
                    $this -> syntax[$token_key]['str'] .= $token[1];
                } else {
                    $this -> syntax[++$token_key] = array(
                        'type' => 'text',
                        'str' => $decomposition['str'].$token[1]
                    );
                }
                $decomposition = array();
                break;
            case 4:
                $decomposition['type'] = 'close';
                $decomposition['str'] .= '/';
                $decomposition['layout'][] = array(1, '/');
                break;
            case 5:
                $decomposition['type'] = 'open';
                $name = strtolower($token[1]);
                $decomposition['name'] = $name;
                $decomposition['str'] .= $token[1];
                $decomposition['layout'][] = array(2, $token[1]);
                $decomposition['attrib'][$name] = '';
                break;
            case 6:
                if (! isset($decomposition['name'])) {
                    $decomposition['name'] = '';
                }
                if (13 == $previous_mode || 19 == $previous_mode) {
                    $decomposition['layout'][] = array(7, $value);
                }
                $decomposition['str'] .= ']';
                $decomposition['layout'][] = array( 0, ']' );
                $this -> syntax[++$token_key] = $decomposition;
                $decomposition = array();
                break;
            case 7:
                $decomposition['name'] = strtolower($token[1]);
                $decomposition['str'] .= $token[1];
                $decomposition['layout'][] = array(2, $token[1]);
                /* При выходе из тега возвращаем умолчальное значение пробельных незакавыченных тегов */
                $finite_automaton = $finite_automaton_orig;
                break;
            case 8:
                $decomposition['str'] .= '=';
                $decomposition['layout'][] = array(3, '=');
                $spacesave = '';
                break;
            case 9:
                $decomposition['type'] = 'open/close';
                $decomposition['str'] .= '/';
                $decomposition['layout'][] = array(1, '/');
                break;
            case 10:
                $decomposition['str'] .= $token[1];
                $decomposition['layout'][] = array(4, $token[1]);
                break;
            case 11:
                $decomposition['str'] .= '"';
                $decomposition['layout'][] = array(5, '"');
                $value = '';
                break;
            case 12:
                $decomposition['str'] .= "'";
                $decomposition['layout'][] = array(5, "'");
                $value = '';
                break;
            case 13:
                /* Включаем режим пробельных незакавыченных тегов если нужно */
                $this->_includeTagFile($decomposition['name']);
                $handler = $this->tags[$decomposition['name']];
                $class_vars = get_class_vars($handler);
                if ($class_vars['oneattrib']) // Переписываем некоторые обработки
                {
                    $finite_automaton[8][6] = 13;
                    $finite_automaton[20][7] = 19;
                    $finite_automaton[20][8] = 19;
                    $finite_automaton[13][6] = 19;
                    $finite_automaton[19][6] = 19;
                }
                $decomposition['attrib'][$name] = $spacesave.$token[1];
                $value = $spacesave.$token[1];
                $decomposition['str'] .= $token[1];
                $spacesave = '';
                break;
            case 14:
                $decomposition['str'] .= $token[1];
                $decomposition['layout'][] = array(4, $token[1]);
                $spacesave .= $token[1];
                break;
            case 15:
                $name = strtolower($token[1]);
                $decomposition['str'] .= $token[1];
                $decomposition['layout'][] = array(6, $token[1]);
                $decomposition['attrib'][$name] = '';
                break;
            case 16:
                $decomposition['str'] .= $token[1];
                $decomposition['attrib'][$name] .= $token[1];
                $value .= $token[1];
                break;
            case 17:
                $decomposition['str'] .= $token[1];
                $decomposition['layout'][] = array(7, $value);
                $value = '';
                $decomposition['layout'][] = array(5, $token[1]);
                break;
            case 18:
                $decomposition['str'] .= $token[1];
                $decomposition['attrib'][$name] .= $token[1];
                $value .= $token[1];
                break;
            case 19:
                $decomposition['str'] .= $token[1];
                $decomposition['attrib'][$name] .= $token[1];
                $value .= $token[1];
                break;
            case 20:
                $decomposition['str'] .= $token[1];
                if ( 13 == $previous_mode || 19 == $previous_mode ) {
                    $decomposition['layout'][] = array(7, $value);
                }
                $value = '';
                $decomposition['layout'][] = array(4, $token[1]);
                break;
            }
        }
        if ($decomposition) {
            if ('text' === $type) {
                $this -> syntax[$token_key]['str'] .= $decomposition['str'];
            } else {
                $this -> syntax[++$token_key] = array(
                    'type' => 'text',
                    'str' => $decomposition['str']
                );
            }
        }
        $this->_get_tree();
        $this->stat['time_parse'] = $this->_getmicrotime() - $time_start;
        return $this->syntax;
    }


    /**
     * _specialchars
     *
     * @param $string
     * @return string
     */
    protected function _specialchars($string)
    {
        $chars = array(
            '[' => '@l;',
            ']' => '@r;',
            '"' => '@q;',
            "'" => '@a;',
            '@' => '@at;'
        );
        return strtr($string, $chars);
    }


    /**
     * _unspecialchars
     *
     * @param $string
     * @return string
     */
    protected function _unspecialchars($string)
    {
        $chars = array(
            '@l;'  => '[',
            '@r;'  => ']',
            '@q;'  => '"',
            '@a;'  => "'",
            '@at;' => '@'
        );
        return strtr($string, $chars);
    }


    /**
     * Функция проверяет, должен ли тег с именем $current закрыться,
     * если начинается тег с именем $next.
     *
     * @param string $current
     * @param string $next
     * @return bool
     */
    protected function _must_close_tag($current, $next)
    {
        if (isset($this -> tags[$current])) {
            $this->_includeTagFile($current);
            $class_vars = get_class_vars($this -> tags[$current]);
            $current_behaviour = $class_vars['behaviour'];
        } else {
            $current_behaviour = $this->behaviour;
        }
        if (isset($this -> tags[$next])) {
            $this->_includeTagFile($next);
            $class_vars = get_class_vars($this -> tags[$next]);
            $next_behaviour = $class_vars['behaviour'];
        } else {
            $next_behaviour = $this->behaviour;
        }
        $must_close = false;
        if (isset($this->_ends[$current_behaviour])) {
            $must_close = in_array($next_behaviour, $this->_ends[$current_behaviour]);;
        }
        return $must_close;
    }


    /**
     * Возвращает true, если тег с именем $parent может иметь непосредственным
     * потомком тег с именем $child. В противном случае - false.
     * Если $parent - пустая строка, то проверяется, разрешено ли $child входить в
     * корень дерева BBCode.
     *
     * @param string $parent
     * @param string $child
     * @return bool
     */
    protected function _isPermissiblyChild($parent, $child)
    {
        $parent = (string) $parent;
        $child = (string) $child;
        if (isset($this -> tags[$parent])) {
            $this->_includeTagFile($parent);
            $class_vars = get_class_vars($this -> tags[$parent]);
            $parent_behaviour = $class_vars['behaviour'];
        } else {
            $parent_behaviour = $this->behaviour;
        }
        if (isset($this -> tags[$child])) {
            $this->_includeTagFile($child);
            $class_vars = get_class_vars($this -> tags[$child]);
            $child_behaviour = $class_vars['behaviour'];
        } else {
            $child_behaviour = $this->behaviour;
        }
        $permissibly = true;
        if (isset($this->_children[$parent_behaviour])) {
            $permissibly = in_array(
                $child_behaviour, $this->_children[$parent_behaviour]
            );
        }
        return $permissibly;
    }


    /**
     * _normalize_bracket
     *
     * @param array $syntax
     * @return array
     */
    protected function _normalize_bracket($syntax)
    {
        $structure = array();
        $structure_key = -1;
        $level = 0;
        $open_tags = array();
        foreach ($syntax as $val) {
            unset($val['layout']);
            switch ($val['type']) {
                case 'text':
                    $val['str'] = $this -> _unspecialchars($val['str']);
                    $type = (-1 < $structure_key)
                        ? $structure[$structure_key]['type'] : false;
                    if ('text' === $type) {
                        $structure[$structure_key]['str'] .= $val['str'];
                    } else {
                        $structure[++$structure_key] = $val;
                        $structure[$structure_key]['level'] = $level;
                    }
                    break;
                case 'open/close':
                    $val['attrib'] = array_map(
                        array($this, '_unspecialchars'), $val['attrib']
                    );
                    foreach (array_reverse($open_tags, true) as $ult_key => $ultimate) {
                        if ($this -> _must_close_tag($ultimate, $val['name'])) {
                            $structure[++$structure_key] = array(
                                    'type'  => 'close',
                                    'name'  => $ultimate,
                                    'str'   => '',
                                    'level' => --$level
                                );
                            unset($open_tags[$ult_key]);
                        } else {
                            break;
                        }
                    }
                    $structure[++$structure_key] = $val;
                    $structure[$structure_key]['level'] = $level;
                    break;
                case 'open':
                    $this->_includeTagFile($val['name']);
                    $val['attrib'] = array_map(
                        array($this, '_unspecialchars'), $val['attrib']
                    );
                    foreach (array_reverse($open_tags, true) as $ult_key => $ultimate) {
                        if ($this -> _must_close_tag($ultimate, $val['name'])) {
                            $structure[++$structure_key] = array(
                                    'type'  => 'close',
                                    'name'  => $ultimate,
                                    'str'   => '',
                                    'level' => --$level
                                );
                            unset($open_tags[$ult_key]);
                        } else {
                            break;
                        }
                    }
                    $class_vars = get_class_vars($this -> tags[$val['name']]);
                    if ($class_vars['is_close']) {
                        $val['type'] = 'open/close';
                        $structure[++$structure_key] = $val;
                        $structure[$structure_key]['level'] = $level;
                    } else {
                        $structure[++$structure_key] = $val;
                        $structure[$structure_key]['level'] = $level++;
                        $open_tags[] = $val['name'];
                    }
                    break;
                case 'close':
                    if (!$open_tags) {
                        $type = (-1 < $structure_key)
                            ? $structure[$structure_key]['type'] : false;
                        if ( 'text' === $type ) {
                            $structure[$structure_key]['str'] .= $val['str'];
                        } else {
                            $structure[++$structure_key] = array(
                                    'type'  => 'text',
                                    'str'   => $val['str'],
                                    'level' => 0
                                );
                        }
                        break;
                    }
                    if (! $val['name']) {
                        end($open_tags);
                        list($ult_key, $ultimate) = each($open_tags);
                        $val['name'] = $ultimate;
                        $structure[++$structure_key] = $val;
                        $structure[$structure_key]['level'] = --$level;
                        unset($open_tags[$ult_key]);
                        break;
                    }
                    if (! in_array($val['name'], $open_tags)) {
                        $type = (-1 < $structure_key)
                            ? $structure[$structure_key]['type'] : false;
                        if ('text' === $type) {
                            $structure[$structure_key]['str'] .= $val['str'];
                        } else {
                            $structure[++$structure_key] = array(
                                    'type'  => 'text',
                                    'str'   => $val['str'],
                                    'level' => $level
                                );
                        }
                        break;
                    }
                    foreach (array_reverse($open_tags, true) as $ult_key => $ultimate) {
                        if ($ultimate != $val['name']) {
                            $structure[++$structure_key] = array(
                                    'type'  => 'close',
                                    'name'  => $ultimate,
                                    'str'   => '',
                                    'level' => --$level
                                );
                            unset($open_tags[$ult_key]);
                        } else {
                            break;
                        }
                    }
                    $structure[++$structure_key] = $val;
                    $structure[$structure_key]['level'] = --$level;
                    unset($open_tags[$ult_key]);
            }
        }
        foreach (array_reverse($open_tags, true) as $ult_key => $ultimate) {
            $structure[++$structure_key] = array(
                    'type'  => 'close',
                    'name'  => $ultimate,
                    'str'   => '',
                    'level' => --$level
                );
            unset($open_tags[$ult_key]);
        }
        return $structure;
    }


    /**
     * _get_tree
     *
     * @return array
     */
    protected function _get_tree()
    {
        /* Превращаем $this -> syntax в правильную скобочную структуру */
        $structure = $this -> _normalize_bracket($this -> syntax);
        /* Отслеживаем, имеют ли элементы неразрешенные подэлементы.
           Соответственно этому исправляем $structure. */
        $normalized = array();
        $normal_key = -1;
        $level = 0;
        $open_tags = array();
        $not_tags = array();
        $this -> stat['count_tags'] = 0;
        foreach ($structure as $val) {
            switch ($val['type']) {
                case 'text':
                    $type = (-1 < $normal_key)
                        ? $normalized[$normal_key]['type'] : false;
                    if ('text' === $type) {
                        $normalized[$normal_key]['str'] .= $val['str'];
                    } else {
                        $normalized[++$normal_key] = $val;
                        $normalized[$normal_key]['level'] = $level;
                    }
                    break;
                case 'open/close':
                    $this->_includeTagFile($val['name']);
                    end($open_tags);
                    $parent = $open_tags ? current($open_tags) : $this->tag;
                    $permissibly = $this->_isPermissiblyChild($parent, $val['name']);
                    if (! $permissibly) {
                        $type = (-1 < $normal_key)
                            ? $normalized[$normal_key]['type'] : false;
                        if ( 'text' === $type ) {
                            $normalized[$normal_key]['str'] .= $val['str'];
                        } else {
                            $normalized[++$normal_key] = array(
                                    'type'  => 'text',
                                    'str'   => $val['str'],
                                    'level' => $level
                                );
                        }
                        break;
                    }
                    $normalized[++$normal_key] = $val;
                    $normalized[$normal_key]['level'] = $level;
                    $this -> stat['count_tags'] += 1;
                    break;
                case 'open':
                    $this->_includeTagFile($val['name']);
                    end($open_tags);
                    $parent = $open_tags ? current($open_tags) : $this->tag;
                    $permissibly = $this->_isPermissiblyChild($parent, $val['name']);
                    if (! $permissibly) {
                        $not_tags[$val['level']] = $val['name'];
                        $type = (-1 < $normal_key)
                            ? $normalized[$normal_key]['type'] : false;
                        if ( 'text' === $type ) {
                            $normalized[$normal_key]['str'] .= $val['str'];
                        } else {
                            $normalized[++$normal_key] = array(
                                    'type'  => 'text',
                                    'str'   => $val['str'],
                                    'level' => $level
                                );
                        }
                        break;
                    }
                    $normalized[++$normal_key] = $val;
                    $normalized[$normal_key]['level'] = $level++;
                    $ult_key = count($open_tags);
                    $open_tags[$ult_key] = $val['name'];
                    $this -> stat['count_tags'] += 1;
                    break;
                case 'close':
                    $not_normal = isset($not_tags[$val['level']])
                        && $not_tags[$val['level']] = $val['name'];
                    if ($not_normal) {
                        unset($not_tags[$val['level']]);
                        $type = (-1 < $normal_key)
                            ? $normalized[$normal_key]['type'] : false;
                        if ( 'text' === $type ) {
                            $normalized[$normal_key]['str'] .= $val['str'];
                        } else {
                            $normalized[++$normal_key] = array(
                                    'type'  => 'text',
                                    'str'   => $val['str'],
                                    'level' => $level
                                );
                        }
                        break;
                    }
                    $normalized[++$normal_key] = $val;
                    $normalized[$normal_key]['level'] = --$level;
                    $ult_key = count($open_tags) - 1;
                    unset($open_tags[$ult_key]);
                    $this -> stat['count_tags'] += 1;
                    break;
            }
        }
        unset($structure);
        // Формируем дерево элементов
        $result = array();
        $result_key = -1;
        $open_tags = array();
        $this -> stat['count_level'] = 0;
        foreach ($normalized as $val) {
            switch ($val['type']) {
                case 'text':
                    if (! $val['level']) {
                        $result[++$result_key] = array(
                            'type' => 'text',
                            'str' => $val['str']
                        );
                        break;
                    }
                    $open_tags[$val['level'] - 1]['val'][] = array(
                            'type' => 'text',
                            'str' => $val['str']
                        );
                    break;
                case 'open/close':
                    if (! $val['level']) {
                        $result[++$result_key] = array(
                            'type'   => 'item',
                            'name'   => $val['name'],
                            'attrib' => $val['attrib'],
                            'val'    => array()
                        );
                        break;
                    }
                    $open_tags[$val['level'] - 1]['val'][] = array(
                        'type'   => 'item',
                        'name'   => $val['name'],
                        'attrib' => $val['attrib'],
                        'val'    => array()
                    );
                    break;
                case 'open':
                    $open_tags[$val['level']] = array(
                        'type'   => 'item',
                        'name'   => $val['name'],
                        'attrib' => $val['attrib'],
                        'val'    => array()
                    );
                    break;
                case 'close':
                    if (! $val['level']) {
                        $result[++$result_key] = $open_tags[0];
                        unset($open_tags[0]);
                        break;
                    }
                    $open_tags[$val['level'] - 1]['val'][] = $open_tags[$val['level']];
                    unset($open_tags[$val['level']]);
                    break;
            }
            if ($val['level'] > $this -> stat['count_level']) {
                $this -> stat['count_level'] += 1;
            }
        }
        $this -> tree = $result;
        return $result;
    }


    /**
     * _get_syntax
     *
     * @param bool|array $tree
     * @return array
     */
    function _get_syntax($tree = false)
    {
        if (! is_array($tree)) {
            $tree = $this -> tree;
        }
        $syntax = array();
        foreach ($tree as $elem) {
            if ('text' === $elem['type']) {
                $syntax[] = array(
                    'type' => 'text',
                    'str' => $this -> _specialchars($elem['str'])
                );
            } else {
                $sub_elems = $this -> _get_syntax($elem['val']);
                $str = '';
                $layout = array(array(0, '['));
                foreach ($elem['attrib'] as $name => $val) {
                    $val = $this -> _specialchars($val);
                    if ($str) {
                        $str .= ' ';
                        $layout[] = array(4, ' ');
                        $layout[] = array(6, $name);
                    } else {
                        $layout[] = array(2, $name);
                    }
                    $str .= $name;
                    if ($val) {
                        $str .= '="' . $val . '"';
                        $layout[] = array(3, '=');
                        $layout[] = array(5, '"');
                        $layout[] = array(7, $val);
                        $layout[] = array(5, '"');
                    }
                }
                if ($sub_elems) {
                    $str = '[' . $str . ']';
                } else {
                    $str = '['.$str.' /]';
                    $layout[] = array(4, ' ');
                    $layout[] = array(1, '/');
                }
                $layout[] = array(0, ']');
                $syntax[] = array(
                    'type' => $sub_elems ? 'open' : 'open/close',
                    'str' => $str,
                    'name' => $elem['name'],
                    'attrib' => $elem['attrib'],
                    'layout' => $layout
                );
                foreach ($sub_elems as $sub_elem) {
                    $syntax[] = $sub_elem;
                }
                if ($sub_elems) {
                    $syntax[] = array(
                        'type' => 'close',
                        'str' => '[/' . $elem['name'] . ']',
                        'name' => $elem['name'],
                        'layout' => array(
                            array(0, '['),
                            array(1, '/'),
                            array(2, $elem['name']),
                            array(0, ']')
                        )
                    );
                }
            }
        }
        return $syntax;
    }


    /**
     * insert_smiles
     *
     * @param string $text
     * @return string
     */
    public function insert_smiles($text)
    {
        $text = htmlspecialchars($text, ENT_NOQUOTES);
        if ($this -> autolinks) {
            $search = $this -> preg_autolinks['pattern'];
            $replace = $this -> preg_autolinks['replacement'];
            $text = preg_replace($search, $replace, $text);
        }
        $text = str_replace('  ', '&#160;&#160;', nl2br($text));
        $text = strtr($text, $this -> mnemonics);
        return $text;
    }


    /**
     * highlight
     *
     * @return string
     */
    public function highlight()
    {
        $time_start = $this -> _getmicrotime();
        $chars = array(
            '@l;'  => '<span class="bb_spec_char">@l;</span>',
            '@r;'  => '<span class="bb_spec_char">@r;</span>',
            '@q;'  => '<span class="bb_spec_char">@q;</span>',
            '@a;'  => '<span class="bb_spec_char">@a;</span>',
            '@at;' => '<span class="bb_spec_char">@at;</span>'
        );
        $search = $this -> preg_autolinks['pattern'];
        $replace = $this -> preg_autolinks['highlight'];
        $str = '';
        foreach ($this -> syntax as $elem) {
            if ('text' === $elem['type']) {
                $elem['str'] = strtr(htmlspecialchars($elem['str']), $chars);
                foreach ($this -> mnemonics as $mnemonic => $value) {
                    $elem['str'] = str_replace(
                        $mnemonic,
                        '<span class="bb_mnemonic">' . $mnemonic . '</span>',
                        $elem['str']
                    );
                }
                $elem['str'] = preg_replace($search, $replace, $elem['str']);
                $str .= $elem['str'];
            } else {
                $str .= '<span class="bb_tag">';
                foreach ($elem['layout'] as $val) {
                    switch ($val[0]) {
                        case 0:
                            $str .= '<span class="bb_bracket">' . $val[1]
                                . '</span>';
                            break;
                        case 1:
                            $str .= '<span class="bb_slash">/</span>';
                            break;
                        case 2:
                            $str .= '<span class="bb_tagname">'.$val[1]
                                .'</span>';
                            break;
                        case 3:
                            $str .= '<span class="bb_equal">=</span>';
                            break;
                        case 4:
                            $str .= $val[1];
                            break;
                        case 5:
                            if (! trim($val[1])) {
                                $str .= $val[1];
                            } else {
                                $str .= '<span class="bb_quote">' . $val[1]
                                    . '</span>';
                            }
                            break;
                        case 6:
                            $str .= '<span class="bb_attrib_name">'
                                . htmlspecialchars($val[1]) . '</span>';
                            break;
                        case 7:
                            if (! trim($val[1])) {
                                $str .= $val[1];
                            } else {
                                $str .= '<span class="bb_attrib_val">'
                                    . strtr(htmlspecialchars($val[1]), $chars)
                                    . '</span>';
                            }
                            break;
                        default:
                            $str .= $val[1];
                    }
                }
                $str .= '</span>';
            }
        }
        $str = nl2br($str);
        $str = str_replace('  ', '&#160;&#160;', $str);
        $this -> stat['time_html'] = $this -> _getmicrotime() - $time_start;
        return $str;
    }


    /**
     * Возвращает HTML код
     *
     * @param array $elems
     * @return string
     */
    public function get_html($elems = null)
    {
        $time_start = $this -> _getmicrotime();
        if (! is_array($elems)) {
            $elems =& $this -> tree;
        }
        $result = '';
        $lbr = 0;
        $rbr = 0;
        foreach ($elems as $elem) {
            if ('text' === $elem['type']) {
                $elem['str'] = $this -> insert_smiles($elem['str']);
                for ($i = 0; $i < $rbr; ++$i) {
                    $elem['str'] = ltrim($elem['str']);
                    if ('<br />' === substr($elem['str'], 0, 6)) {
                        $elem['str'] = substr_replace($elem['str'], '', 0, 6);
                    }
                }
                $result .= $elem['str'];
            } else {
                $this->_includeTagFile($elem['name']);
                $handler = $this->tags[$elem['name']];
                /* Убираем лишние переводы строк */
                $class_vars = get_class_vars($handler);
                $lbr = $class_vars['lbr'];
                $rbr = $class_vars['rbr'];
                for ($i = 0; $i < $lbr; ++$i) {
                    $result = rtrim($result);
                    if ('<br />' === substr($result, -6)) {
                        $result = substr_replace($result, '', -6, 6);
                    }
                }
                /* Обрабатываем содержимое элемента */
                $tag = $this->_tag_objects[$handler];
                $tag->autolinks = $this->autolinks;
                $tag->tags = $this->tags;
                $tag->mnemonics = $this->mnemonics;
                $tag->tag = $elem['name'];
                $tag->attrib = $elem['attrib'];
                $tag->tree = $elem['val'];
                $result .= $tag -> get_html();
            }
        }
        $result = preg_replace(
            "'\s*<br \/>\s*<br \/>\s*'si", "\n<br />&#160;<br />\n", $result
        );
        $this->stat['time_html'] = $this->_getmicrotime() - $time_start;
        return $result;
    }


    /**
     * Аналог parse_str но без преобразования точек и пробелов в подчеркивания
     *
     * @todo не очень хорошая реализация
     * @param string $str
     * @return array
     */
    protected function _parseStr ($str)
    {
        $original = array('.', ' ');
        $replace = array("xbbdot\txbbdot", "xbbspace\txbbspace");

        parse_str(str_replace($original, $replace, $str), $query);

        foreach ($query as $k => $v) {
            unset($query[$k]);
            $query[str_replace($replace, $original, $k)] = str_replace($replace, $original, $v);
        }

        return $query;
    }


    /**
     * Функция преобразует строку URL в соответствии с RFC 3986
     *
     * @param string $url
     * @return string
     */
    protected function _checkUrl($url)
    {
        $parse = parse_url($url);

        $out = '';
        if (isset($parse['scheme'])) {
            $out .= $parse['scheme'] . '://';
        }
        if (isset($parse['user']) && isset($parse['pass'])) {
            $out .= rawurlencode($parse['user']) . ':' . rawurlencode($parse['pass']) . '@';
        } else if (isset($parse['user'])) {
            $out .= rawurlencode($parse['user']) . '@';
        }
        if (isset($parse['host'])) {
            $out .= rawurlencode($parse['host']);
        }
        if (isset($parse['port'])) {
            $out .= ':' . $parse['port'];
        }
        if (isset($parse['path'])) {
            $out .= str_replace('%2F', '/', rawurlencode($parse['path']));
        }
        if (isset($parse['query'])) {
            $query = $this->_parseStr($parse['query']);
            //parse_str($parse['query'], $query); //replace spaces and dots

            // PHP 5.1.2
            // PHP 5.4.0 - PHP_QUERY_RFC3986
            $out .= '?' . str_replace('+', '%20', rtrim(http_build_query($query, '', '&amp;'), '='));
        }
        if (isset($parse['fragment'])) {
            $out .= '#' . rawurlencode($parse['fragment']);
        }

        return $out;
    }


    /**
     * Функция возвращает текущий UNIX timestamp с микросекундами в формате float
     *
     * @return float
     */
    protected function _getmicrotime()
    {
        return microtime(true);
    }


    /**
     * Функция проверяет, доступен ли класс - обработчик тега с именем $tagName и,
     * если нет, пытается подключить файл с соответствующим классом. Если это не
     * возможно, переназначает тегу обработчик, - сопоставляет ему класс bbcode.
     * Затем инициализирует объект обработчика (если он еще не инициализирован).
     *
     * @param string $tagName
     * @return bool
     */
    protected function _includeTagFile($tagName)
    {
        if (!isset($this->tags[$tagName])) {
            $this->tags[$tagName] = 'bbcode';
        }

        $handler = $this->tags[$tagName];
        if (!isset($this->_tag_objects[$handler])) {
            $this->_tag_objects[$handler] = new $handler;
        }

        return true;
    }
}