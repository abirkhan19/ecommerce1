<div>
  <div class="breadcrumbs">
      <div class="container">
          <div class="row">
              <div class="col-xs-12">
                  <ul>
                      <li class="home"><a title="Go to Home Page" href="index.html">Home</a><span>&raquo;</span></li>
                      <li><strong>About Us</strong></li>
                  </ul>
              </div>
          </div>
      </div>
  </div>

  <div class="main container" style="margin-top:10px;margin-bottom:10px;">
      <?php if ($page): ?>
          <?=$page->details;?>
      <?php else: ?>
          <p>Page not found.</p>
      <?php endif; ?>
  </div>
</div>

@push('js')
  <script src="{{ asset('front/theme/js/tinymce/tinymce.min.js') }}"></script>
  <script>
    document.addEventListener('DOMContentLoaded', function () {
        initializeTinyMCEForAll();
    });
    
    document.addEventListener('editorLoaded', function () {
        setTimeout(() => {
            initializeTinyMCEForAll();
        }, 100);
    });
    
    function initializeTinyMCEForAll() {
        console.log('Initializing all TinyMCE editors...');
        let textareas = document.querySelectorAll('textarea[data-holder-id]');  
        
        textareas.forEach((textarea) => {
            let holderId = textarea.getAttribute('data-holder-id');  
            initializeTinyMCE(holderId, textarea);
        });
    }
    
    function initializeTinyMCE(holderId, textarea) {
        console.log('Initializing TinyMCE for:', holderId);
    
        if (typeof tinymce !== 'undefined') {
            let editor = tinymce.get('editor-' + holderId);
            if (editor) {
                tinymce.remove('#editor-' + holderId); // Remove the previous instance of TinyMCE
                console.log('Removing old TinyMCE instance for holderId:', holderId);
            }
    
            tinymce.init({
                selector: '#editor-' + holderId,  
                plugins: 'advlist autolink lists link image charmap print preview hr anchor pagebreak',
                toolbar_mode: 'floating',
                setup: function (editor) {
                    console.log('TinyMCE initialized for component:', holderId);
    
                    // Load content into editor on initialization
                    editor.on('init', function () {
                        let content = textarea.value; // This should have the initial content from Livewire
                        editor.setContent(content); // Set the initial content into TinyMCE
                        console.log('Initial content loaded:', content);
                    });
    
                  editor.on('change', function () {
                      let content = editor.getContent();
                      console.log('Dispatching syncContent:', { holderId: holderId, content: content });
                      Livewire.dispatch('syncContent', { holderId: '231', content: '<p>daf</p>' });
                  });
                }
            });
        }
    }
    
    $(document).on('click', '#syncContentBtn', function () {
    let holderId = $(this).data('holder-id');
    let editor = tinymce.get('editor-' + holderId);
    
    if (editor) {
        let content = editor.getContent();
        console.log('Syncing content to backend:', content);

        // Emit an event to Livewire to update the model dynamically
        Livewire.dispatch('syncContent', holderId, content); // Emitting the event with holderId and content
    }
});
    </script>
    
@endpush
