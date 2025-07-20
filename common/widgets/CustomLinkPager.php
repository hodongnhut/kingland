<?php
namespace common\widgets;

use Yii;
use yii\helpers\Html;
use yii\widgets\LinkPager;

class CustomLinkPager extends LinkPager
{
    public $maxButtonCount = 5;
    public $prevPageLabel = '<i class="fas fa-chevron-left"></i>';
    public $nextPageLabel = '<i class="fas fa-chevron-right"></i>';
    public $firstPageLabel = false;
    public $lastPageLabel = false;

    protected function renderPageButtons()
    {
        $pagination = $this->pagination;
        $totalCount = $pagination->totalCount;
        $totalPages = $pagination->getPageCount();
        
        // Handle edge case: no pages or single page
        if ($totalPages <= 1) {
            return '';
        }

        $page = (int)$pagination->getPage() + 1; // Current page (1-based, cast to int for safety)
        $buttons = [];

        // Mobile View
        $mobileButtons = [];
        $prevLink = $pagination->getPage() > 0 ? $pagination->createUrl($pagination->getPage() - 1) : '#';
        $nextLink = $pagination->getPage() < $totalPages - 1 ? $pagination->createUrl($pagination->getPage() + 1) : '#';

        $mobileButtons[] = Html::a(
            Yii::t('app', 'Previous'),
            $prevLink,
            [
                'class' => 'relative inline-flex items-center rounded-md border border-gray-300 bg-white px-4 py-2 text-sm font-medium text-gray-700 hover:bg-gray-50' . ($pagination->getPage() <= 0 ? ' opacity-50 cursor-not-allowed' : ''),
                'aria-label' => Yii::t('app', 'Go to previous page'),
                'aria-disabled' => $pagination->getPage() <= 0 ? 'true' : null,
            ]
        );
        $mobileButtons[] = Html::a(
            Yii::t('app', 'Next'),
            $nextLink,
            [
                'class' => 'relative ml-3 inline-flex items-center rounded-md border border-gray-300 bg-white px-4 py-2 text-sm font-medium text-gray-700 hover:bg-gray-50' . ($pagination->getPage() >= $totalPages - 1 ? ' opacity-50 cursor-not-allowed' : ''),
                'aria-label' => Yii::t('app', 'Go to next page'),
                'aria-disabled' => $pagination->getPage() >= $totalPages - 1 ? 'true' : null,
            ]
        );

        // Desktop View: Page Info
        $pageInfo = Html::tag(
            'p',
            Yii::t('app', 'Total {totalCount} items, Page {currentPage}/{totalPages}', [
                'totalCount' => number_format($totalCount),
                'currentPage' => $page,
                'totalPages' => $totalPages,
            ]),
            ['class' => 'text-sm text-gray-700']
        );
        $pageInfo = Html::tag('div', $pageInfo);

        // Desktop View: Navigation
        $navButtons = [];

        // Previous Button
        $navButtons[] = Html::a(
            '<span class="sr-only">' . Yii::t('app', 'Previous') . '</span>' . $this->prevPageLabel,
            $prevLink,
            [
                'class' => 'relative inline-flex items-center rounded-l-md px-2 py-2 text-gray-400 ring-1 ring-inset ring-gray-300 hover:bg-gray-50 focus:z-20 focus:outline-offset-0' . ($pagination->getPage() <= 0 ? ' opacity-50 cursor-not-allowed' : ''),
                'aria-label' => Yii::t('app', 'Go to previous page'),
                'aria-disabled' => $pagination->getPage() <= 0 ? 'true' : null,
            ]
        );

        // Page Numbers
        $startPage = max(0, $page - floor($this->maxButtonCount / 2));
        $endPage = min($startPage + $this->maxButtonCount - 1, $totalPages - 1);

        if ($endPage - $startPage + 1 < $this->maxButtonCount) {
            $startPage = max(0, $endPage - $this->maxButtonCount + 1);
        }

        for ($i = $startPage; $i <= $endPage; $i++) {
            $isCurrent = ((int)$i + 1) === $page; // Ensure strict comparison with int casting
            $navButtons[] = Html::a(
                $i + 1,
                $pagination->createUrl($i),
                [
                    'class' => 'relative inline-flex items-center px-4 py-2 text-sm font-semibold '
                        . ($isCurrent
                            ? 'z-10 bg-blue-600 text-white focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-blue-600'
                            : 'text-gray-900 ring-1 ring-inset ring-gray-300 hover:bg-gray-50 focus:z-20 focus:outline-offset-0'),
                    'aria-current' => $isCurrent ? 'page' : null,
                    'aria-label' => $isCurrent ? Yii::t('app', 'Current page, page {page}', ['page' => $i + 1]) : Yii::t('app', 'Go to page {page}', ['page' => $i + 1]),
                ]
            );
        }

        if ($endPage < $totalPages - 1) {
            $navButtons[] = Html::tag(
                'span',
                '...',
                ['class' => 'relative inline-flex items-center px-4 py-2 text-sm font-semibold text-gray-700 ring-1 ring-inset ring-gray-300 focus:outline-offset-0']
            );
        }

        // Next Button
        $navButtons[] = Html::a(
            '<span class="sr-only">' . Yii::t('app', 'Next') . '</span>' . $this->nextPageLabel,
            $nextLink,
            [
                'class' => 'relative inline-flex items-center rounded-r-md px-2 py-2 text-gray-400 ring-1 ring-inset ring-gray-300 hover:bg-gray-50 focus:z-20 focus:outline-offset-0' . ($pagination->getPage() >= $totalPages - 1 ? ' opacity-50 cursor-not-allowed' : ''),
                'aria-label' => Yii::t('app', 'Go to next page'),
                'aria-disabled' => $pagination->getPage() >= $totalPages - 1 ? 'true' : null,
            ]
        );

        $nav = Html::tag('nav', implode('', $navButtons), ['class' => 'isolate inline-flex -space-x-px rounded-md shadow-sm', 'aria-label' => 'Pagination']);
        $desktopNav = Html::tag('div', $nav);

        // Combine Desktop View
        $desktopView = Html::tag('div', $pageInfo . $desktopNav, ['class' => 'hidden sm:flex sm:flex-1 sm:items-center sm:justify-between']);

        // Combine Mobile and Desktop Views
        $mobileView = Html::tag('div', implode('', $mobileButtons), ['class' => 'flex flex-1 justify-between sm:hidden']);

        return Html::tag('div', $mobileView . $desktopView, ['class' => 'flex items-center justify-between border-t border-gray-200 bg-white px-4 py-3 sm:px-6 mt-6 rounded-lg shadow-sm']);
    }
}
?>