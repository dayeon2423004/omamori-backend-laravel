<?php

namespace App\Repositories\Stamp;

use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\File;

class StampRepository
{
    /**
     * 스탬프 목록 조회 (필터링 / 정렬 / 페이징).
     *
     * @param  array<string, mixed>  $filters
     * @return LengthAwarePaginator
     */
    public function paginate(array $filters): LengthAwarePaginator
    {
        $dirPath = public_path('assets/stamps');

        // 폴더 없으면 빈 paginator 반환
        if (!File::exists($dirPath)) {
            return new LengthAwarePaginator([], 0, 1, 1);
        }

        $q    = isset($filters['q']) ? (string) $filters['q'] : null;
        $ext  = strtolower((string)($filters['ext'] ?? 'png'));
        $sort = (string)($filters['sort'] ?? 'name');
        $page = max(1, (int)($filters['page'] ?? 1));
        $size = max(1, min(100, (int)($filters['size'] ?? 24)));

        // 파일 목록 가져오기
        $files = collect(File::files($dirPath));

        // 확장자 필터
        $files = $files->filter(function ($file) use ($ext) {
            return strtolower($file->getExtension()) === $ext;
        });

        // 검색 필터
        if ($q !== null && $q !== '') {
            $files = $files->filter(function ($file) use ($q) {
                return mb_stripos($file->getFilenameWithoutExtension(), $q) !== false;
            });
        }

        // 정렬
        if ($sort === 'latest') {
            $files = $files->sortByDesc(fn ($file) => $file->getMTime());
        } else {
            $files = $files->sortBy(fn ($file) => $file->getFilenameWithoutExtension());
        }

        $files = $files->values();

        $total = $files->count();

        $slice = $files->slice(($page - 1) * $size, $size);

        $items = $slice->map(function ($file) {
            $relativePath = 'stamps/' . $file->getFilename();

            return [
                'asset_key' => $file->getFilenameWithoutExtension(),
                'file_name' => $file->getFilename(),
                'url'       => url('/file/' . $relativePath),
            ];
        })->values()->toArray();

        return new LengthAwarePaginator(
            $items,
            $total,
            $size,
            $page,
            [
                'path'  => request()->url(),
                'query' => request()->query(),
            ]
        );
    }
}