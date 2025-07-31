// Analytics and performance tracking for Vehimovil

// Core Web Vitals tracking
function trackCoreWebVitals() {
    if ('PerformanceObserver' in window) {
        // Track Largest Contentful Paint (LCP)
        const lcpObserver = new PerformanceObserver((list) => {
            const entries = list.getEntries();
            const lastEntry = entries[entries.length - 1];
            console.log('LCP:', lastEntry.startTime, 'ms');
        });
        lcpObserver.observe({ entryTypes: ['largest-contentful-paint'] });

        // Track First Input Delay (FID)
        const fidObserver = new PerformanceObserver((list) => {
            const entries = list.getEntries();
            entries.forEach(entry => {
                console.log('FID:', entry.processingStart - entry.startTime, 'ms');
            });
        });
        fidObserver.observe({ entryTypes: ['first-input'] });

        // Track Cumulative Layout Shift (CLS)
        const clsObserver = new PerformanceObserver((list) => {
            let clsValue = 0;
            const entries = list.getEntries();
            entries.forEach(entry => {
                if (!entry.hadRecentInput) {
                    clsValue += entry.value;
                }
            });
            console.log('CLS:', clsValue);
        });
        clsObserver.observe({ entryTypes: ['layout-shift'] });
    }
}

// User interaction tracking
function trackUserInteractions() {
    // Track button clicks
    document.addEventListener('click', (e) => {
        if (e.target.matches('a, button')) {
            const element = e.target.closest('a, button');
            if (element) {
                console.log('User clicked:', element.textContent.trim());
            }
        }
    });

    // Track scroll depth
    let maxScrollDepth = 0;
    window.addEventListener('scroll', () => {
        const scrollDepth = Math.round((window.scrollY / (document.body.scrollHeight - window.innerHeight)) * 100);
        if (scrollDepth > maxScrollDepth) {
            maxScrollDepth = scrollDepth;
            if (maxScrollDepth % 25 === 0) { // Log every 25%
                console.log('Scroll depth:', maxScrollDepth + '%');
            }
        }
    });
}

// Page load performance
function trackPageLoad() {
    window.addEventListener('load', () => {
        setTimeout(() => {
            const perfData = performance.getEntriesByType('navigation')[0];
            const metrics = {
                dns: perfData.domainLookupEnd - perfData.domainLookupStart,
                tcp: perfData.connectEnd - perfData.connectStart,
                ttfb: perfData.responseStart - perfData.requestStart,
                domLoad: perfData.domContentLoadedEventEnd - perfData.domContentLoadedEventStart,
                pageLoad: perfData.loadEventEnd - perfData.loadEventStart,
                total: perfData.loadEventEnd - perfData.fetchStart
            };
            
            console.log('Page Load Metrics:', metrics);
        }, 0);
    });
}

// Initialize tracking
document.addEventListener('DOMContentLoaded', () => {
    trackCoreWebVitals();
    trackUserInteractions();
    trackPageLoad();
});

// Error tracking
window.addEventListener('error', (e) => {
    console.error('JavaScript Error:', {
        message: e.message,
        filename: e.filename,
        lineno: e.lineno,
        colno: e.colno
    });
});

// Unhandled promise rejection tracking
window.addEventListener('unhandledrejection', (e) => {
    console.error('Unhandled Promise Rejection:', e.reason);
}); 