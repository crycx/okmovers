document.addEventListener('DOMContentLoaded', function () {
  var menuToggle = document.querySelector('.menu-toggle');
  var navigation = document.querySelector('.site-navigation');
  var headerInner = document.querySelector('.site-header__inner');

  if (menuToggle && navigation) {
    function setMenuState(isOpen) {
      navigation.classList.toggle('is-open', isOpen);
      menuToggle.setAttribute('aria-expanded', isOpen ? 'true' : 'false');
      document.body.classList.toggle('menu-open', isOpen);

      if (headerInner) {
        headerInner.classList.toggle('has-open-menu', isOpen);
      }
    }

    menuToggle.addEventListener('click', function () {
      var shouldOpen = !navigation.classList.contains('is-open');
      setMenuState(shouldOpen);
    });

    navigation.querySelectorAll('a').forEach(function (link) {
      link.addEventListener('click', function () {
        setMenuState(false);
      });
    });

    document.addEventListener('keydown', function (event) {
      if (event.key === 'Escape' && navigation.classList.contains('is-open')) {
        setMenuState(false);
      }
    });

    document.addEventListener('click', function (event) {
      if (!navigation.classList.contains('is-open')) {
        return;
      }

      if (navigation.contains(event.target) || menuToggle.contains(event.target)) {
        return;
      }

      setMenuState(false);
    });

    window.addEventListener('resize', function () {
      if (window.innerWidth > 1280 && navigation.classList.contains('is-open')) {
        setMenuState(false);
      }
    });
  }

  document.querySelectorAll('.section-nav-toggle').forEach(function (toggleButton) {
    var navId = String(toggleButton.getAttribute('aria-controls') || '');
    var sectionNav = navId ? document.getElementById(navId) : null;
    var floatThreshold = 0;

    if (!sectionNav) {
      return;
    }

    function recalculateFloatThreshold() {
      toggleButton.classList.remove('is-floating');
      floatThreshold = /* toggleButton.getBoundingClientRect().top  */+ window.scrollY + 8;
      console.log("Recalculated float threshold:", floatThreshold, "Toggle button top:", toggleButton.getBoundingClientRect().top, "ScrollY:", window.scrollY);
    }

    function updateFloatingState() {
      console.log('Updating floating state. ScrollY:', window.scrollY, 'Threshold:', floatThreshold);
      if (window.innerWidth > 1024) {
        toggleButton.classList.remove('is-floating');
        return;
      }

      toggleButton.classList.toggle('is-floating', window.scrollY > floatThreshold);
    }

    function setSectionNavState(isOpen) {
      sectionNav.classList.toggle('is-open', isOpen);
      toggleButton.setAttribute('aria-expanded', isOpen ? 'true' : 'false');
      document.body.classList.toggle('section-nav-open', isOpen);
    }

    toggleButton.addEventListener('click', function () {
      var shouldOpen = !sectionNav.classList.contains('is-open');
      setSectionNavState(shouldOpen);
    });

    sectionNav.querySelectorAll('a').forEach(function (link) {
      link.addEventListener('click', function () {
        setSectionNavState(false);
      });
    });

    document.addEventListener('keydown', function (event) {
      if (event.key === 'Escape' && sectionNav.classList.contains('is-open')) {
        setSectionNavState(false);
      }
    });

    document.addEventListener('click', function (event) {
      if (!sectionNav.classList.contains('is-open')) {
        return;
      }

      if (sectionNav.contains(event.target) || toggleButton.contains(event.target)) {
        return;
      }

      setSectionNavState(false);
    });

    window.addEventListener('resize', function () {
      if (window.innerWidth > 1024 && sectionNav.classList.contains('is-open')) {
        setSectionNavState(false);
      }

      recalculateFloatThreshold();
      updateFloatingState();
    });

    window.addEventListener('scroll', updateFloatingState, { passive: true });

    recalculateFloatThreshold();
    updateFloatingState();
  });

  document.querySelectorAll('.faq-item__trigger').forEach(function (trigger) {
    trigger.addEventListener('click', function () {
      var panelId = trigger.getAttribute('aria-controls');
      var panel = panelId ? document.getElementById(panelId) : null;
      var isExpanded = trigger.getAttribute('aria-expanded') === 'true';

      trigger.setAttribute('aria-expanded', isExpanded ? 'false' : 'true');

      if (panel) {
        panel.hidden = isExpanded;
      }
    });
  });

  function bindCarousel(config) {
    document.querySelectorAll(config.carouselSelector).forEach(function (carousel) {
      var items = Array.prototype.slice.call(carousel.querySelectorAll(config.itemSelector));
      var prevButton = carousel.querySelector(config.prevSelector);
      var nextButton = carousel.querySelector(config.nextSelector);
      var track = carousel.querySelector(config.trackSelector);
      var offset = 0;

      if (!items.length) {
        return;
      }

      function getVisibleCount() {
        if (window.innerWidth <= 720) {
          return 1;
        }

        if (window.innerWidth <= 1024) {
          return 3;
        }

        return config.desktopVisibleCount;
      }

      function render() {
        var visibleCount = Math.min(getVisibleCount(), items.length);
        var visibleMap = {};
        var i;

        if (track) {
          track.style.setProperty(config.columnsVariable, String(visibleCount));
        }

        for (i = 0; i < visibleCount; i += 1) {
          visibleMap[(offset + i) % items.length] = true;
        }

        items.forEach(function (item, index) {
          var isVisible = !!visibleMap[index];
          item.hidden = !isVisible;
          item.setAttribute('aria-hidden', isVisible ? 'false' : 'true');
        });

        if (prevButton) {
          prevButton.disabled = items.length <= visibleCount;
        }

        if (nextButton) {
          nextButton.disabled = items.length <= visibleCount;
        }
      }

      if (prevButton) {
        prevButton.addEventListener('click', function () {
          offset = (offset - 1 + items.length) % items.length;
          render();
        });
      }

      if (nextButton) {
        nextButton.addEventListener('click', function () {
          offset = (offset + 1) % items.length;
          render();
        });
      }

      window.addEventListener('resize', render);
      render();
    });
  }

  bindCarousel({
    carouselSelector: '[data-clients-carousel]',
    itemSelector: '[data-clients-item]',
    prevSelector: '[data-clients-prev]',
    nextSelector: '[data-clients-next]',
    trackSelector: '[data-clients-track]',
    columnsVariable: '--clients-columns',
    desktopVisibleCount: 6,
  });

  document.querySelectorAll('[data-testimonials-carousel]').forEach(function (carousel) {
    var items = Array.prototype.slice.call(carousel.querySelectorAll('[data-testimonials-item]'));
    var prevButton = carousel.querySelector('[data-testimonials-prev]');
    var nextButton = carousel.querySelector('[data-testimonials-next]');
    var track = carousel.querySelector('[data-testimonials-track]');
    var offset = 0;

    if (!items.length || !track) {
      return;
    }

    function getVisibleCount() {
      if (window.innerWidth <= 720) {
        return 1;
      }

      if (window.innerWidth <= 1024) {
        return 2;
      }

      return 3;
    }

    function render(withAnimation) {
      var visibleCount = Math.min(getVisibleCount(), items.length);
      var maxOffset = Math.max(0, items.length - visibleCount);
      var currentOffset = Math.min(offset, maxOffset);
      var firstItem = items[0];
      var itemWidth = firstItem ? firstItem.getBoundingClientRect().width : 0;
      var trackStyles = window.getComputedStyle(track);
      var gapValue = parseFloat(trackStyles.columnGap || trackStyles.gap || '0') || 0;
      var step = itemWidth + gapValue;

      if (!withAnimation) {
        track.style.transition = 'none';
      } else {
        track.style.transition = '';
      }

      track.style.setProperty('--testimonials-columns', String(visibleCount));
      track.style.setProperty('--testimonials-gap', gapValue + 'px');
      track.style.transform = 'translate3d(' + (-currentOffset * step) + 'px, 0, 0)';

      if (prevButton) {
        prevButton.disabled = currentOffset === 0;
      }

      if (nextButton) {
        nextButton.disabled = currentOffset >= maxOffset;
      }

      offset = currentOffset;
    }

    if (prevButton) {
      prevButton.addEventListener('click', function () {
        offset = Math.max(0, offset - 1);
        render(true);
      });
    }

    if (nextButton) {
      nextButton.addEventListener('click', function () {
        offset = offset + 1;
        render(true);
      });
    }

    window.addEventListener('resize', function () {
      render(false);
    });

    render(false);
  });

  function setFormResponse(formContainer, status, message) {
    var responseEl = formContainer.querySelector('[data-form-response]');

    if (!responseEl) {
      return;
    }

    responseEl.classList.remove('form-response--success', 'form-response--error', 'is-hidden');
    responseEl.classList.add(status === 'success' ? 'form-response--success' : 'form-response--error');
    responseEl.textContent = message;
    responseEl.hidden = false;

    window.setTimeout(function () {
      responseEl.hidden = true;
      responseEl.classList.add('is-hidden');
      responseEl.textContent = '';
    }, 5000);
  }

  document.querySelectorAll('.contact-form__form').forEach(function (form) {
    if (!window.okmoversTheme || !okmoversTheme.ajaxUrl || !window.fetch || !window.FormData) {
      return;
    }

    form.addEventListener('submit', function (event) {
      event.preventDefault();

      var formContainer = form.closest('[data-contact-form]');
      var submitButton = form.querySelector('button[type="submit"]');
      var formData = new FormData(form);
      var action = String(formData.get('action') || '');
      var requestTimeoutId = 0;
      var didFinish = false;
      var defaultButtonLabel = submitButton ? String(submitButton.getAttribute('data-submit-default-label') || submitButton.textContent || '') : '';
      var loadingButtonLabel = submitButton ? String(submitButton.getAttribute('data-submit-loading-label') || 'SAADAN...') : 'SAADAN...';

      if (!action) {
        return;
      }

      function finishRequest() {
        if (didFinish) {
          return;
        }

        didFinish = true;

        if (requestTimeoutId) {
          window.clearTimeout(requestTimeoutId);
        }

        if (submitButton) {
          submitButton.disabled = false;
        }

        if (formContainer) {
          formContainer.classList.remove('is-loading');
        }

        if (submitButton && defaultButtonLabel) {
          submitButton.textContent = defaultButtonLabel;
        }
      }

      formData.set('action', action + '_ajax');

      if (submitButton) {
        submitButton.disabled = true;
      }

      if (formContainer) {
        formContainer.classList.add('is-loading');
      }

      if (submitButton) {
        submitButton.textContent = loadingButtonLabel;
      }

      requestTimeoutId = window.setTimeout(function () {
        finishRequest();

        if (formContainer) {
          setFormResponse(formContainer, 'error', 'Saatmine vottis liiga kaua aega. Proovige uuesti.');
        }
      }, 25000);

      fetch(okmoversTheme.ajaxUrl, {
        method: 'POST',
        credentials: 'same-origin',
        body: formData,
      })
        .then(function (response) {
          return response.json().catch(function () {
            return null;
          });
        })
        .then(function (payload) {
          var isSuccess = payload && payload.success;
          var data = payload && payload.data ? payload.data : {};
          var message = String(data.message || '');

          if (formContainer) {
            setFormResponse(formContainer, isSuccess ? 'success' : 'error', message || 'Saatmine ebaõnnestus.');
          }

          if (isSuccess) {
            form.reset();

            ['move_type', 'move_window'].forEach(function (fieldName) {
              var firstRadio = form.querySelector('input[type="radio"][name="' + fieldName + '"]');

              if (firstRadio) {
                firstRadio.checked = true;
              }
            });
          }

          finishRequest();
        })
        .catch(function () {
          if (formContainer) {
            setFormResponse(formContainer, 'error', 'Saatmine ebaõnnestus. Proovige uuesti.');
          }
          finishRequest();
        });
    });
  });
});
