<?php
declare(strict_types=1);

namespace josdigital\craftcustomfeatures\services;

use InvalidArgumentException;

final class LoremPicsumService
{
    private const BASE_URL = 'https://picsum.photos';

    /**
     * @param array<string, mixed> $params
     */
    public function image(int $width, int|array|null $height = null, array $params = []): string
    {
        $this->assertDimension($width, 'width');

        if (is_array($height)) {
            $params = $height;
            $height = null;
        }

        $height ??= $width;
        $this->assertDimension($height, 'height');

        $id = $params['id'] ?? null;
        $seed = $params['seed'] ?? null;
        if ($id !== null && $seed !== null) {
            throw new InvalidArgumentException('Picsum image params "id" and "seed" cannot be combined.');
        }

        if (($params['static'] ?? false) === true && $seed === null && $id === null) {
            $seed = sprintf('lorempicsum-%dx%d', $width, $height);
        }

        $prefix = self::BASE_URL;
        if ($id !== null) {
            $prefix .= '/id/' . $this->pathPart($id, 'id');
        } elseif ($seed !== null) {
            $prefix .= '/seed/' . $this->pathPart($seed, 'seed');
        }

        $extension = $params['extension'] ?? $params['format'] ?? null;
        if ($extension !== null) {
            $extension = strtolower(ltrim((string) $extension, '.'));
            if (!in_array($extension, ['jpg', 'webp'], true)) {
                throw new InvalidArgumentException('Picsum format must be "jpg" or "webp".');
            }
        }

        $dimensions = sprintf('/%d/%d', $width, $height);
        if ($extension !== null) {
            $dimensions .= '.' . $extension;
        }

        $query = [];
        if (($params['grayscale'] ?? false) === true) {
            $query[] = 'grayscale';
        }

        if (array_key_exists('blur', $params) && $params['blur'] !== false && $params['blur'] !== null) {
            if ($params['blur'] === true) {
                $query[] = 'blur';
            } else {
                $blur = filter_var($params['blur'], FILTER_VALIDATE_INT);
                if ($blur === false || $blur < 1 || $blur > 10) {
                    throw new InvalidArgumentException('Picsum blur must be true or an integer from 1 to 10.');
                }
                $query[] = 'blur=' . $blur;
            }
        }

        if (array_key_exists('random', $params) && $params['random'] !== false && $params['random'] !== null) {
            $random = $params['random'] === true ? '1' : (string) $params['random'];
            $query[] = 'random=' . rawurlencode($random);
        } elseif (array_key_exists('static', $params) && $params['static'] === false && $seed === null && $id === null) {
            $query[] = 'random=1';
        }

        return $prefix . $dimensions . ($query ? '?' . implode('&', $query) : '');
    }

    /**
     * @param array<string, mixed> $params
     */
    public function square(int $size, array $params = []): string
    {
        return $this->image($size, $size, $params);
    }

    /**
     * @param array<string, mixed> $params
     */
    public function imageById(int|string $id, int $width, ?int $height = null, array $params = []): string
    {
        $params['id'] = $id;

        return $this->image($width, $height, $params);
    }

    /**
     * @param array<string, mixed> $params
     */
    public function imageBySeed(string|int $seed, int $width, ?int $height = null, array $params = []): string
    {
        $params['seed'] = $seed;

        return $this->image($width, $height, $params);
    }

    /**
     * @param array<string, int> $params
     */
    public function images(array $params = []): string
    {
        $query = [];
        if (isset($params['page'])) {
            $this->assertPositiveInteger($params['page'], 'page');
            $query['page'] = $params['page'];
        }
        if (isset($params['limit'])) {
            $this->assertPositiveInteger($params['limit'], 'limit');
            $query['limit'] = $params['limit'];
        }

        return self::BASE_URL . '/v2/list' . ($query ? '?' . http_build_query($query) : '');
    }

    public function imageInfo(int|string $id): string
    {
        return self::BASE_URL . '/id/' . $this->pathPart($id, 'id') . '/info';
    }

    public function seedInfo(string|int $seed): string
    {
        return self::BASE_URL . '/seed/' . $this->pathPart($seed, 'seed') . '/info';
    }

    private function assertDimension(int $value, string $name): void
    {
        $this->assertPositiveInteger($value, $name);
    }

    private function assertPositiveInteger(mixed $value, string $name): void
    {
        if (!is_int($value) || $value < 1) {
            throw new InvalidArgumentException(sprintf('Picsum %s must be a positive integer.', $name));
        }
    }

    private function pathPart(int|string $value, string $name): string
    {
        if ((string) $value === '') {
            throw new InvalidArgumentException(sprintf('Picsum %s cannot be empty.', $name));
        }

        return rawurlencode((string) $value);
    }
}
