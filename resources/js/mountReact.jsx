import React from 'react';
import { createRoot } from 'react-dom/client';
import AnalyticsGraph from './components/AnalyticsGraph';
import ProgramDashboard from './components/ProgramBuilder/ProgramDashboard';
import AnatomyHeatmap from './components/Analytics/AnatomyHeatmap';
import WeeklyAnalyticsDashboard from './components/Analytics/WeeklyAnalyticsDashboard';
import SidebarNavigation from './components/Navigation/SidebarNavigation';
import Dashboard from './components/Dashboard/Dashboard';
import WorkoutPage from './components/Workout/WorkoutPage';
import AICoach from './components/AICoach/AICoach';
import WellnessHub from './components/Wellness/WellnessHub';
import BottomNavigation from './components/Navigation/BottomNavigation';

import PricingPage from './components/Pricing/PricingPage';

import ProfileSettings from './components/Profile/ProfileSettings';

const mountComponent = (id, Component, initialProps = {}) => {
    const el = document.getElementById(id);
    if (el) {
        const props = { ...initialProps };
        
        // Automatically parse all data-* attributes
        Object.keys(el.dataset).forEach(key => {
            try {
                props[key] = JSON.parse(el.dataset[key]);
            } catch (e) {
                props[key] = el.dataset[key];
            }
        });

        // Specific legacy mapping for path
        if (el.dataset.path) props.currentPath = el.dataset.path;
        
        const root = createRoot(el);
        root.render(<Component {...props} />);
    }
};

mountComponent('analytics-graph-root', AnalyticsGraph);
mountComponent('program-dashboard-root', ProgramDashboard);
mountComponent('anatomy-heatmap-root', AnatomyHeatmap);
mountComponent('weekly-analytics-root', WeeklyAnalyticsDashboard);
mountComponent('sidebar-navigation-root', SidebarNavigation);
mountComponent('dashboard-root', Dashboard);
mountComponent('workout-page-root', WorkoutPage);
mountComponent('ai-coach-root', AICoach);
mountComponent('wellness-hub-root', WellnessHub);
mountComponent('bottom-navigation-root', BottomNavigation);
mountComponent('pricing-page-root', PricingPage);
mountComponent('profile-settings-root', ProfileSettings);
