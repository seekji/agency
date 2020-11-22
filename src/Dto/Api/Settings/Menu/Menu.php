<?php

declare(strict_types=1);

namespace App\Dto\Api\Settings\Menu;

use JMS\Serializer\Annotation\Type;

class Menu
{
    /**
     * @Type("string")
     */
    public string $title;

    /**
     * @Type("string")
     */
    public string $link;

    /**
     * @Type("int")
     */
    public int $sort;

    /**
     * @Type("boolean")
     */
    public bool $external;

    public function __construct(array $menuItem)
    {
        $this->title = $menuItem['title'] ? : '';
        $this->link = $menuItem['link'] ? : '';
        $this->sort = $menuItem['sort'] ? : 0;
        $this->external = $menuItem['external'] ?: false;
    }
}
