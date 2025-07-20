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

        $page = (int)$pagination->getPage() + 1; // Current page (1-based)
        $buttons = [];

        // --- Mobile View (remains largely the same) ---
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

        // --- Desktop View: Page Info and Dropdown ---
        $pageInfo = Html::tag(
            'p',
            Yii::t('app', 'Tổng {totalCount} mục, Trang {currentPage}/{totalPages}', [ // Đã dịch
                'totalCount' => number_format($totalCount),
                'currentPage' => $page,
                'totalPages' => $totalPages,
            ]),
            ['class' => 'text-sm text-gray-700']
        );
        $pageInfo = Html::tag('div', $pageInfo);

        // Dropdown for page selection
        $options = [];
        for ($i = 0; $i < $totalPages; $i++) {
            $options[$pagination->createUrl($i)] = Yii::t('app', 'Trang {page}', ['page' => $i + 1]);
        }
        
        // Label for the dropdown
        $dropdownLabel = Html::tag(
            'label',
            Yii::t('app', ' '),
            ['for' => 'page-selector', 'class' => 'sr-only sm:not-sr-only text-sm font-medium text-gray-700 ml-4']
        );

        $dropdown = Html::dropDownList(
            'page-selector',
            $pagination->createUrl($pagination->getPage()),
            $options,
            [
                'id' => 'page-selector',
                'class' => 'block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm
                            py-2 pl-3 pr-8 text-base leading-5 text-gray-900 focus:outline-none sm:text-sm',
                'onchange' => 'window.location.href = this.value;',
                'aria-label' => Yii::t('app', 'Select page'),
            ]
        );
        
        // Container for dropdown and its label
        $dropdownContainer = Html::tag('div', $dropdownLabel . $dropdown, ['class' => 'flex items-center mr-auto sm:mr-4']); // Changed ml-auto to mr-auto


        // --- Desktop View: Navigation (buttons) ---
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
            $isCurrent = ((int)$i + 1) === $page;
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
        
        // **Crucial Change Here:** Reordered elements
        // Now it's dropdown first, then page info, then nav buttons
        $desktopNavComponents = Html::tag('div', $dropdownContainer . $pageInfo . $nav, ['class' => 'flex items-center w-full justify-between']);
        
        $desktopView = Html::tag('div', $desktopNavComponents, ['class' => 'hidden sm:flex sm:flex-1 sm:items-center sm:justify-between']);

        // Combine Mobile and Desktop Views
        $mobileView = Html::tag('div', implode('', $mobileButtons), ['class' => 'flex flex-1 justify-between sm:hidden']);

        return Html::tag('div', $mobileView . $desktopView, ['class' => 'flex items-center justify-between border-t border-gray-200 bg-white px-4 py-3 sm:px-6 mt-6 rounded-lg shadow-sm']);
    }
}
?>