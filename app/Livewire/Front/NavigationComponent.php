<?php

namespace App\Livewire\Front;

use App\Models\Page;
use Livewire\Component;
use App\Models\PageSection;
use Livewire\Attributes\On;
use Livewire\WithFileUploads;
use App\Models\WithLinkComponent;
use App\Models\WithImageComponent;
use App\Models\WithGaleryComponent;
use Illuminate\Support\Facades\File;
use Intervention\Image\Facades\Image;
use App\Livewire\Front\Components\Dispatcher;

class NavigationComponent extends Component
{
    use WithFileUploads;

    public $slug;
    public $msg;
    public $page;
    public $mode='';
    public $galleryImages = [];
    public $getGalleryImages = [];
    public $sectionId;
    public $bulkImagesOpen = false;
    public $deletePreviousImages;
    public $sectionContent;
    public $sectionContents = [];
    public $componentId;
    public $componentType;
    public $holderId;
    protected $listeners = ['syncContent' => 'syncContentToLivewire'];
    public function mount($slug)
    {
        $this->page = Page::with('pageSections')->where('slug', $slug)->first();
       
    }

    public function render()
    {
    
        return view('livewire.front.navigation-component', ['page' => $this->page])->layout('layouts.front');
    }

   

    public function changeMode($mode,$componentId,$componentType)
    {

        $this->mode = $mode;

        $this->componentId = $componentId;

        $this->componentType = $componentType;

        $this->holderId = $mode;

        if($this->componentType=='slideSection')
        {
            $this->sectionContent = PageSection::find($this->componentId)->content;
        }
        if ($this->componentType == 'withImage') {
            $this->sectionContents["{$this->sectionId}-{$this->componentId}"] = WithImageComponent::find($this->componentId)->content;
        
        }
        $this->dispatch('editorLoaded');
       
    }
    
    public function syncContentToLivewire($holderId,$content)
    {
    
        $this->sectionContents[$holderId] = $content;
        $this->sectionContent = $content;
        $this->dispatch('editorLoaded');

    }
    public function resetMode()
    {
        $this->mode = '';
        $this->dispatch('editorLoaded');    
    }
    public function updateComponent($componentId,$componentType,$sectionId)
    {
        if($componentType=='slideSection')
        {
            $section = PageSection::find($sectionId);
            $dynamicKey = "{$sectionId}";
           dd($this->sectionContent);
            if(isset($this->sectionContents[$dynamicKey]))
            {
                $section->content = $this->sectionContents[$dynamicKey];
              
                $section->update();
                $this->mode = '';
                toastr()->success('Section content updated successfully');
                $this->dispatch('editorLoaded');
            }
            else{
                $this->dispatch('editorLoaded');
                toastr()->error("Content for the section {$dynamicKey} is missing.");
            }
           
        }
        if ($componentType == 'withImage') {
            // Construct the dynamic key for sectionContents
            $dynamicKey = "{$sectionId}-{$componentId}";
         
            // Check if the content exists for this key
            if (isset($this->sectionContents[$dynamicKey])) {
                $section = WithImageComponent::find($componentId);
                // Update the content for this section
                $section->content = $this->sectionContents[$dynamicKey];
      
                // Update the section in the database
                $section->update();
                $this->mode = '';
                toastr()->success('Section content updated successfully');
                $this->dispatch('editorLoaded');
            } else {
                $this->dispatch('editorLoaded');
                toastr()->error("Content for the section {$dynamicKey} is missing.");
            }
        }
    }
    public function removeTwoColumnsSection($sectionId)
    {
        $section = PageSection::find($sectionId);
        if(File::exists('front/theme/images/sections/section-' . $section->id . '-page-' . $section->attributable_id)) {
            File::deleteDirectory('front/theme/images/sections/section-' . $section->id . '-page-' . $section->attributable_id);
        }
        $section->withImage()->delete();
        $section->delete();
    }
    public function removeSectionFromPage($sectionId)
    {
        PageSection::find($sectionId)->delete();
        toastr()->success('Section removed successfully');
    }

    public function getSectionSlider($id)
    {
        $this->sectionId = $id;
        $pageSection = PageSection::with('myGalery')->find($id);
        $imagePaths = [];
        foreach ($pageSection->myGalery as $image) {
            $imagePaths[] = $image->photo;
        }
        $this->getGalleryImages = $imagePaths;
    }

    public function updatedDeletePreviousImages()
    {
        
        $section = PageSection::find($this->sectionId);
        $gallery = $section->myGalery;
        foreach ($gallery as $image) {
            $imagePath = 'front/theme/images/sections/section-' . $section->id . '-page-' . $section->attributable_id . '/' . $image->photo;
            if(File::exists($imagePath))
            {
                File::delete($imagePath);
            }
        }
        $section->myGalery()->delete();
        $this->getGalleryImages = [];
    }

    public function updatedGalleryImages()
    {
       
        $section = PageSection::find($this->sectionId);
        if (!empty($this->galleryImages)) {
            $dirPath = 'front/theme/images/sections/section-' . $this->sectionId . '-page-' . $section->attributable_id;
            if (!File::exists($dirPath)) {
                File::makeDirectory($dirPath, 0777, true, true);
            }

            $imagePaths = [];
            foreach ($this->galleryImages as $image) {
                $imageName = $image->getClientOriginalName();
                $path = $dirPath . '/' . $imageName;
               
                Image::make($image)->resize(600, 400)->save($path);

                $createGalery = WithGaleryComponent::create([
                    'attributable_id' => $this->sectionId,
                    'photo' => $imageName,
                    'attributable_type' => 'App\Models\PageSection'
                ]);

                $imagePaths[] = $imageName;
            }

            $this->getGalleryImages = $imagePaths;
        }
    }

    public function removeSlideImage($sectionId,$image)
    {
        $section = PageSection::find($sectionId);
        $imagePath = 'front/theme/images/sections/section-' . $sectionId . '-page-' . $section->attributable_id . '/' . $image;
        if(File::exists($imagePath))
        {
            File::delete($imagePath);
        }
        WithGaleryComponent::where('photo', $image)->delete();
        $this->getSectionSlider($sectionId);
    }
}
