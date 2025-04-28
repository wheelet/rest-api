<?php

declare(strict_types=1);

namespace app\dto;

use yii\base\Model;

abstract class BaseDto
{
    /**
     * BaseDto constructor.
     * Allows creating a DTO instance directly from a Model (form)
     *
     * @param Model|null $form Form to create DTO from
     */
    public function __construct(?Model $form = null)
    {
        if ($form !== null) {
            $this->mapFromModel($form);
        }
    }

    /**
     * Create a new DTO instance from array
     *
     * @param array<string, mixed> $data Data to create DTO from
     * @return static The DTO instance
     */
    public static function fromArray(array $data): self
    {
        $dto = new static();

        foreach ($data as $property => $value) {
            if (property_exists($dto, $property)) {
                $dto->$property = $value;
            }
        }

        return $dto;
    }

    /**
     * Create a new DTO instance from a Model
     *
     * @param Model $model Model to create DTO from
     * @return static The DTO instance
     */
    public static function fromModel(Model $model): self
    {
        $dto = new static();
        $dto->mapFromModel($model);

        return $dto;
    }

    /**
     * Map data from a Model to this DTO
     *
     * @param Model $model Model to map data from
     */
    protected function mapFromModel(Model $model): void
    {
        $attributes = $model->getAttributes();

        foreach ($attributes as $attribute => $value) {
            if (property_exists($this, $attribute)) {
                $this->$attribute = $value;
            }
        }
    }

    /**
     * Convert DTO to array
     *
     * @return array<string, mixed>
     */
    public function toArray(): array
    {
        return get_object_vars($this);
    }
}
