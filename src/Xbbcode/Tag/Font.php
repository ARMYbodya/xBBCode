<?php

/******************************************************************************
 *                                                                            *
 *   Font.php, v 0.00 2007/04/21 - This is part of xBB library                *
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

namespace Xbbcode\Tag;

use Xbbcode\Xbbcode;

// Класс для тега [font]
class Font extends Xbbcode
{
    public $behaviour = 'span';

    public function getHtml($tree = null)
    {
        $attr = '';
        if (isset($this -> attrib['face'])) {
            $face = $this -> attrib['face'];
        } else {
            $face = $this -> attrib['font'];
        }
        if ($face) {
            $attr .= ' face="' . $this->htmlspecialchars($face) . '"';
        }
        $color = isset($this -> attrib['color']) ? $this -> attrib['color'] : '';
        if ($color) { $attr .= ' color="' . $this->htmlspecialchars($color) . '"'; }
        $size = isset($this -> attrib['size']) ? $this -> attrib['size'] : '';
        if ($size) { $attr .= ' size="' . $this->htmlspecialchars($size) . '"'; }

        return '<font' . $attr . '>' . parent::getHtml($this -> tree) . '</font>';
    }
}
