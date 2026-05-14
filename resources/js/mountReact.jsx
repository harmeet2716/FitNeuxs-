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

const mountComponent = (id, Component, props = {}) => {
    const el = document.getElementById(id);
    if (el) {
        // Read props from data attributes if provided
        const path = el.dataset.path;
        if (path) props.currentPath = path;
        
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
