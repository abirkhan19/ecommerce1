<?php

namespace App\Livewire\Admin;

use App\Models\Page;
use Livewire\Component;
use App\Models\PageSection;
use App\Models\WithImageComponent;
use App\Models\WithGaleryComponent;
use Illuminate\Support\Facades\File;
use Intervention\Image\Facades\Image;

class DemoFrontComponent extends Component
{
  
    public $pageId;

    public $alterPage;

    public $getLinkId = null;

    public function mount($pageId,$alterPage)
    {
        $this->pageId = $pageId;
        $this->alterPage = Page::find($alterPage);
    }
    public function render()
    {
        $page = Page::find($this->pageId);
        
        return view('livewire.admin.demo-front-component',[
            'page' => $page,
            'alterPage' => $this->alterPage
        ])->layout('layouts.front');
    }

    public function addSliderSectionSectionToPage($sectionId,$alterPageId)
    {        
        $page = Page::find($alterPageId);
        $section = PageSection::find($sectionId);
        $oldPage = Page::find(6);
        // Create the new section
        $createSection = PageSection::create([
            'attributable_id' => $page->id,
            'view_name' => $section->view_name,
            'attributable_type' => 'App\Models\Page'
        ]);
        
        // Define the old and new directories
        $oldDir = 'front/theme/images/sections/section-' . $section->id . '-page-' . $oldPage->id;
        $newDir = 'front/theme/images/sections/section-' . $createSection->id . '-page-' . $page->id;
        
        // Check if the new directory exists, if not, create it
        if (!File::exists($newDir)) {
            File::makeDirectory($newDir, 0777, true, true);
        }
        
        // Define the old image path (assuming it's stored as 'photo' in your gallery)
        $oldImage = 'about_us_slide1.jpg'; // Example image name, should be dynamic based on your data
        $oldImagePath = $oldDir . '/' . $oldImage;
 
        // Check if the old image exists
        if (File::exists($oldImagePath)) {
            // Define the new image path
            $newImagePath = $newDir . '/' . $oldImage;
        
            // Copy the image from the old directory to the new directory
            File::copy($oldImagePath, $newImagePath);
        
            // Store the image in the new gallery component (using the new section)
            WithGaleryComponent::create([
                'attributable_id' => $createSection->id,
                'attributable_type' => 'App\Models\PageSection',
                'photo' => $oldImage // Save the image name in the database
            ]);
        
            toastr()->success('Section Added and Image Copied Successfully');
        } else {
            toastr()->error('Original image not found');
        }

    }

    

    public function addTwoColumnsSection($sectionId,$alterPageId)
    {
        $page = Page::find($alterPageId);
        $section = PageSection::find($sectionId);
        $attributable_id = $page->id;
        $attributable_type = 'App\Models\Page';
        $view_name = $section->view_name;
        $oldPage = Page::find(6);
        $dirPath ='front/theme/images/sections/section-' . $section->id . '-page-' . $oldPage->id;
      
        $createSection = PageSection::create([
            'attributable_id' => $attributable_id,
            'view_name' => $view_name,
            'attributable_type' => $attributable_type
        ]);
        $newDir = 'front/theme/images/sections/section-' . $createSection->id . '-page-' . $page->id;
        if(!File::exists($newDir))
        {
            File::makeDirectory($newDir, 0777, true, true);
        }
        $image1 = $dirPath . '/blog-img1.jpg';
        $image2 = $dirPath . '/blog-img2.jpg';
        if(File::exists($image1))
        {
            $newImage1 = $newDir . '/blog-img1.jpg';
            File::copy($image1, $newImage1);
        }
        if(File::exists($image2))
        {
            $newImage2 = $newDir . '/blog-img2.jpg';
            File::copy($image2, $newImage2);
        }
        foreach($section->withImage as $component)
        {
            
            WithImageComponent::create([
                'attributable_id' => $createSection->id,
                'attributable_type' => 'App\Models\PageSection',
                'title' => $component->title,
                'content' => $component->content,
                'image' => $component->image
            ]);
        }
        toastr()->success('Section Added Successfully');
    }

    public function addThreeColumnSection($sectionId,$alterPageId)
    {
        $page = Page::find($alterPageId);
        $section = PageSection::find($sectionId);
        $attributable_id = $page->id;
        $attributable_type = 'App\Models\Page';
        $view_name = $section->view_name;
        $oldPage = Page::find(6);
        $dirPath ='front/theme/images/sections/section-' . $section->id . '-page-' . $oldPage->id;
      
        $createSection = PageSection::create([
            'attributable_id' => $attributable_id,
            'view_name' => $view_name,
            'attributable_type' => $attributable_type
        ]);
        $newDir = 'front/theme/images/sections/section-' . $createSection->id . '-page-' . $page->id;
        if(!File::exists($newDir))
        {
            File::makeDirectory($newDir, 0777, true, true);
        }
        $image1 = $dirPath . '/blog-img1.jpg';
        $image2 = $dirPath . '/blog-img2.jpg';
        $image3 = $dirPath . '/blog-img3.jpg';
        if(File::exists($image1))
        {
            $newImage1 = $newDir . '/blog-img1.jpg';
            File::copy($image1, $newImage1);
        }
        if(File::exists($image2))
        {
            $newImage2 = $newDir . '/blog-img2.jpg';
            File::copy($image2, $newImage2);
        }
        if(File::exists($image3))
        {
            $newImage3 = $newDir . '/blog-img3.jpg';
            File::copy($image3, $newImage3);
        }
        foreach($section->withImage as $component)
        {
            
            WithImageComponent::create([
                'attributable_id' => $createSection->id,
                'attributable_type' => 'App\Models\PageSection',
                'title' => $component->title,
                'content' => $component->content,
                'image' => $component->image
            ]);
        }
        toastr()->success('Section Added Successfully');
    }

    public function addFaqSection($sectionId,$alterPageId)
    {

    }

    public function addCategorySection($sectionId,$alterPageId)
    {
        PageSection::create([
            'attributable_id' => $alterPageId,
            'view_name' => 'categories-view',
            'attributable_type' => 'App\Models\Page'
        ]);

        toastr()->success('Section Added Successfully');
    }

    
}
