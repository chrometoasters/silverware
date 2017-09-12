/* Tag Cloud Component
===================================================================================================================== */

import $ from 'jquery';

$(function() {
  
  // Handle Tag Cloud Components:
  
  $('.tagcloudcomponent').each(function() {
    
    var $self   = $(this);
    var $canvas = $($self.data('canvas'));
    
    // Initialise Tag Canvas:
    
    $canvas.tagcanvas({
      depth: parseFloat($self.data('depth')),
      zoom: parseFloat($self.data('zoom')),
      zoomMin: parseFloat($self.data('zoom-min')),
      zoomMax: parseFloat($self.data('zoom-max')),
      textColour: $self.data('color-text'),
      outlineColour: $self.data('color-outline'),
      initial: $self.data('initial'),
      weightSizeMin: parseInt($self.data('weight-size-min')),
      weightSizeMax: parseInt($self.data('weight-size-max')),
      weightFrom: 'data-weight',
      weight: $self.data('weight')
    }, $self.data('tag-list'));
    
  });
  
  // Define Resize Handler:
  
  var resizeTagCloud = function() {
    
    $('.tagcloudcomponent').each(function() {
      
      var $self   = $(this);
      var $canvas = $($self.data('canvas'));
      
      var width = $self.width();
      
      $canvas.attr('width', width);
      
    });
    
  };
  
  // Attach Resize Handler:
  
  var id = null;
  
  $(window).resize(function() {
    if (id !== null) clearTimeout(id);
    id = setTimeout(resizeTagCloud, 500);
  });
  
  // Perform Initial Resize:
  
  $(window).on('load', function() {
    resizeTagCloud();
  });
  
});
