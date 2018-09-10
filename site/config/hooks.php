<?php
//kirby()->hook('panel.page.update', function($page, $oldPage = null) {
//    if (in_array($page->parent()->uid(), ['speisen', 'getraenke']) && $this->site()->language()->code() == 'de') {
//
//        $defaultLangData = [];
//        foreach ($page->items()->toStructure() as $key => $entries) {
//            foreach ($entries as $label => $entry) {
//                $defaultLangData[$key][$label] = $entry->value();
//            }
//        }
//
//        $enContent = $page->content('en');
//        $fieldsToCopy = ['price', 'image'];
//
//        $enStructureData = [];
//        $oldEnStructureData = $enContent->get('items')->toStructure();
//
//        foreach ($oldEnStructureData as $key => $row) {
//            foreach ($row as $fieldName => $field) {
//                $enStructureData[$key][$fieldName] = $field;
//                if (in_array($fieldName, $fieldsToCopy)) {
//                    $enStructureData[$key][$fieldName]->value = $defaultLangData[$key][$fieldName];
//                }
//            }
//        }
//
//        $page->update([
//           'items' => yaml::encode($enStructureData)
//        ], 'en');
//    }
//});


kirby()->hook('panel.page.update', function($page, $oldPage = null) {
    if (in_array($page->parent()->uid(), ['speisen', 'getraenke']) && $page->uid() != 'download' && $this->site()->language()->code() == 'de') {
        /** @var Page $page */
        if (!empty($filepath = $page->textfile(null, 'en'))) {
            f::remove($filepath);
        }
    }
});

kirby()->hook('panel.page.update', function($page, $oldPage = null) {
    /** @var Page $page */
    if ($page->parent()->uid() == "powerlunch") {

        $pdfPreviewUrl = 'http://extern.panten.de/wallstreet/showCurrentPdf.php?start=' . $page->start_date() . '&code=news1988';
        $page->update(['preview' => $pdfPreviewUrl]);
    }
});

