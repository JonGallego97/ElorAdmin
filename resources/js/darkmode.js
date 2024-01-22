/*!
 * Color mode toggler for Bootstrap's docs (https://getbootstrap.com/)
 * Copyright 2011-2023 The Bootstrap Authors
 * Licensed under the Creative Commons Attribution 3.0 Unported License.
 */

(() => {
    'use strict'

    const getStoredTheme = () => localStorage.getItem('theme')
    const setStoredTheme = theme => localStorage.setItem('theme', theme)

    const getPreferredTheme = () => {
      const storedTheme = getStoredTheme()
      if (storedTheme) {
        return storedTheme
      }

      return window.matchMedia('(prefers-color-scheme: dark)').matches ? 'dark' : 'light'
    }

    const setTheme = theme => {
      if (theme === 'auto' && window.matchMedia('(prefers-color-scheme: dark)').matches) {
        document.documentElement.setAttribute('data-bs-theme', 'dark')
      } else {
        document.documentElement.setAttribute('data-bs-theme', theme)
      }
    }

    const updateThemeIcons = theme => {
        const themeIcons = {
          light: {
            active: 'bi bi-circle-half my-1 theme-icon-active',
            inactive1: 'bi bi-brightness-high-fill theme-icon',
            inactive2: 'bi bi-moon-stars-fill theme-icon',
          },
          dark: {
            active: 'bi bi-moon-stars-fill theme-icon-active',
            inactive1: 'bi bi-brightness-high-fill theme-icon',
            inactive2: 'bi bi-circle-half my-1 theme-icon',
          },
          auto: {
            active: 'bi bi-circle-half my-1 theme-icon-active',
            inactive1: 'bi bi-brightness-high-fill theme-icon',
            inactive2: 'bi bi-moon-stars-fill theme-icon',
          },
        };

        const themeSwitcher = document.querySelector('#bd-theme');
        if (!themeSwitcher) {
          return;
        }

        const activeThemeIcon = themeIcons[theme].active;
        const inactiveIcon1 = themeIcons[theme].inactive1;
        const inactiveIcon2 = themeIcons[theme].inactive2;

        const activeThemeIconElement = themeSwitcher.querySelector('.theme-icon-active');
        const inactiveIcon1Element = themeSwitcher.querySelector('.theme-icon.sun-icon');
        const inactiveIcon2Element = themeSwitcher.querySelector('.theme-icon.moon-icon');

        activeThemeIconElement.setAttribute('class', activeThemeIcon);
        inactiveIcon1Element.setAttribute('class', inactiveIcon1);
        inactiveIcon2Element.setAttribute('class', inactiveIcon2);
      };
    setTheme(getPreferredTheme())

    const showActiveTheme = (theme, focus = false) => {
      const themeSwitcher = document.querySelector('#bd-theme')

      if (!themeSwitcher) {
        return
      }

      const themeSwitcherText = document.querySelector('#bd-theme-text')
      const activeThemeIcon = document.querySelector('.theme-icon-active use')
      const btnToActive = document.querySelector(`[data-bs-theme-value="${theme}"]`)
      const svgOfActiveBtn = btnToActive.querySelector('svg use').getAttribute('href')

      document.querySelectorAll('[data-bs-theme-value]').forEach(element => {
        element.classList.remove('active')
        element.setAttribute('aria-pressed', 'false')
      })

      btnToActive.classList.add('active')
      btnToActive.setAttribute('aria-pressed', 'true')
      activeThemeIcon.setAttribute('href', svgOfActiveBtn)
      const themeSwitcherLabel = `${themeSwitcherText.textContent} (${btnToActive.dataset.bsThemeValue})`
      themeSwitcher.setAttribute('aria-label', themeSwitcherLabel)

      if (focus) {
        themeSwitcher.focus()
      }
    }

    window.matchMedia('(prefers-color-scheme: dark)').addEventListener('change', () => {
      const storedTheme = getStoredTheme()
      if (storedTheme !== 'light' && storedTheme !== 'dark') {
        setTheme(getPreferredTheme())
      }
    })

    window.addEventListener('DOMContentLoaded', () => {
      showActiveTheme(getPreferredTheme())

      document.querySelectorAll('[data-bs-theme-value]')
        .forEach(toggle => {
          toggle.addEventListener('click', () => {
            const theme = toggle.getAttribute('data-bs-theme-value')
            setStoredTheme(theme)
            setTheme(theme)
            showActiveTheme(theme, true)
            updateThemeIcons(theme)
          })
        })
    })
  })()
