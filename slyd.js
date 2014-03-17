var Slyd = Slyd || {}





Slyd.elements = {
  slydr: $('.slydr'),
  slyds: $('.slyds'),
  slydList: $('.slyd'),
  slydrNav: $('.slydr-nav'),
  slydrNext: $('.slydr-next'),
  slydrPrevious: $('.slydr-previous')
}





Slyd.init = function () {
  var _this = Slyd,
      el = _this.elements,
      slydr = el.slydr,
      slyds = el.slyds,
      slydList = el.slydList,
      slydrNav = el.slydrNav,
      slydrNext = el.slydrNext,
      slydrPrevious = el.slydrPrevious
  
  slydr.addClass('slydr-loading')
  
  _this.loaded = 0
  _this.slydCount = slydList.length
  
  //slyds.css('width', _this.slydCount * 100 + '%')
  
  if (slydr.data('delay')) {
    _this.delay = parseInt(slydr.data('delay'))
  } else {
    _this.delay = 5000
  }
  
  slydr.hover(_this.pause, _this.start)
  slydrNav.addClass('slydr-nav-' + slydr.data('nav'))
  slydrNext.click(_this.next)
  slydrPrevious.click(_this.previous)
  
  slydList.each(function(){
    var $this = $(this),
        $image = $(document.createElement('img')).addClass('slyd-image')
    
    $image.attr('src', $this.data('image')).load(function(){
      $this.prepend($image)
      _this.loaded++
      if (_this.loaded === _this.slydCount) {
        slydList.first().addClass('slyd-active')
        _this.start
      }
    })
    
    $this.click(function(){ window.location = $this.data('href') })
  })
}





Slyd.start = function () {
  var _this = Slyd,
      el = _this.elements,
      slydr = el.slydr
  
  slydr.removeClass('slydr-loading')
  _this.timer = setInterval(_this.next, _this.delay)
}





Slyd.pause = function () {
  var _this = Slyd
  
  clearInterval(_this.timer)
}





Slyd.next = function () {
  var _this = Slyd,
      el = _this.elements,
      slydr = el.slydr,
      slydList = el.slydList,
      oldSlyd = $('.slyd-active'),
      newSlyd
  
  if ($('.slyd-active').next().length > 0) {
    newSlyd = oldSlyd.next()
  } else {
    newSlyd = $('.slyd').first()
  }
  
  oldSlyd.removeClass('slyd-active').addClass('slyd-out')
  newSlyd.removeClass('slyd-out').addClass('slyd-active')
}





Slyd.previous = function () {
  var _this = Slyd,
      el = _this.elements,
      slydr = el.slydr,
      slydList = el.slydList
  
  console.log('Rewinding Slydr')
}



jQuery(document).ready(function(){
  Slyd.init()
})