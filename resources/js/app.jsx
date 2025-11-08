import { createRoot } from 'react-dom/client';

const defaultPage = {
    heroTitle: 'Study smarter. Learn faster. Stay connected.',
    heroSubtitle:
        'The UNI portal keeps every role aligned - a single workspace for announcements, schedules, and shared resources.',
    features: [
        {
            title: 'Role-based dashboards',
            description: 'Give professors, students, and administrators focused views tailored to the actions they take every day.',
        },
        {
            title: 'Announcements that land',
            description: 'Publish once and let notifications surface the right information to the right cohort instantly.',
        },
        {
            title: 'Sharing without friction',
            description: 'Store syllabi, lecture decks, and reference materials in one secure location with version clarity.',
        },
        {
            title: 'Schedules that stay current',
            description: 'Manage course calendars, exams, and deadlines with effortless updates that cascade to the whole team.',
        },
        {
            title: 'Actionable insights',
            description: 'Monitor engagement and tailor future announcements or resources using lightweight metrics.',
        },
        {
            title: 'Ready for growth',
            description: 'Whether you are onboarding a small department or an entire campus, the portal scales gracefully.',
        },
    ],
    contactEmail: 'admin@university.edu',
    latestAnnouncements: [],
};

const metrics = [
    { label: 'Active courses', value: '120+' },
    { label: 'Professor accounts', value: '45' },
    { label: 'Student sign-ins', value: '4.8k' },
    { label: 'Resources shared', value: '15k' },
];

const workflowSteps = [
    {
        title: 'Admins define structure',
        description: 'Create roles, permissions, and schedule templates that match your institution.',
    },
    {
        title: 'Professors publish updates',
        description: 'Upload resources, post announcements, and manage course schedules in minutes.',
    },
    {
        title: 'Students act quickly',
        description: 'Dashboards surface what matters today so students can stay on top of deadlines.',
    },
    {
        title: 'Everyone stays aligned',
        description: 'Real-time updates and analytics keep communication tight across the academic term.',
    },
];

const quickLinks = [
    { label: 'Announcements', href: '/announcements' },
    { label: 'Schedules', href: '/schedule' },
    { label: 'Support', href: '/contact' },
    { label: 'Sign in', href: '/login' },
];

const formatDate = (isoDate) => {
    if (!isoDate) {
        return null;
    }
    const date = new Date(isoDate);
    if (Number.isNaN(date.getTime())) {
        return null;
    }
    return date.toLocaleDateString(undefined, {
        month: 'short',
        day: 'numeric',
        year: 'numeric',
    });
};

const Header = () => (
    <header className="border-b border-slate-900/10 bg-white/70 backdrop-blur">
        <div className="mx-auto flex h-16 max-w-6xl items-center justify-between px-6">
            <a href="/" className="text-lg font-semibold tracking-tight text-slate-900">
                UNI Portale
            </a>
            <nav className="hidden gap-6 text-sm font-medium text-slate-600 md:flex">
                <a className="transition hover:text-slate-900" href="/about">
                    About
                </a>
                <a className="transition hover:text-slate-900" href="/contact">
                    Contact
                </a>
                <a className="transition hover:text-slate-900" href="/schedule">
                    Schedules
                </a>
                <a
                    className="rounded-full bg-slate-900 px-4 py-1.5 text-sm font-semibold text-white shadow-sm transition hover:bg-slate-700"
                    href="/login"
                >
                    Sign in
                </a>
            </nav>
        </div>
    </header>
);

const Hero = ({ title, subtitle }) => (
    <section className="relative overflow-hidden bg-slate-900 text-white">
        <div className="absolute inset-0 bg-gradient-to-br from-slate-900 via-indigo-900 to-blue-900" />
        <div className="absolute -right-20 top-24 h-64 w-64 rounded-full bg-blue-400/30 blur-3xl" />
        <div className="absolute -left-16 bottom-10 h-72 w-72 rounded-full bg-white/10 blur-3xl" />

        <div className="relative mx-auto grid max-w-6xl gap-12 px-6 py-24 lg:grid-cols-[minmax(0,1fr)_360px] lg:items-center">
            <div>
                <p className="text-sm font-semibold uppercase tracking-[0.35em] text-blue-200">University portal</p>
                <h1 className="mt-6 text-4xl font-bold leading-tight tracking-tight md:text-5xl lg:text-6xl">{title}</h1>
                <p className="mt-6 max-w-2xl text-lg leading-relaxed text-slate-200">{subtitle}</p>
                <div className="mt-8 flex flex-wrap gap-3">
                    <a
                        href="/login"
                        className="inline-flex items-center gap-2 rounded-full bg-white px-6 py-2.5 text-sm font-semibold text-slate-900 shadow-lg shadow-blue-900/40 transition hover:bg-slate-100"
                    >
                        Enter the portal
                    </a>
                    <a
                        href="/announcements"
                        className="inline-flex items-center gap-2 rounded-full border border-white/20 px-6 py-2.5 text-sm font-semibold text-white transition hover:border-white hover:text-blue-100"
                    >
                        Browse announcements
                    </a>
                </div>
            </div>

            <div className="rounded-3xl border border-white/10 bg-white/5 p-8 shadow-2xl backdrop-blur">
                <h2 className="text-lg font-semibold text-white">Designed for every role</h2>
                <ul className="mt-6 space-y-4 text-sm text-slate-200">
                    <li className="flex gap-3">
                        <span className="mt-1 h-2.5 w-2.5 shrink-0 rounded-full bg-blue-300" />
                        <span>Admins orchestrate the ecosystem with guardrails that simplify governance.</span>
                    </li>
                    <li className="flex gap-3">
                        <span className="mt-1 h-2.5 w-2.5 shrink-0 rounded-full bg-blue-300" />
                        <span>Professors publish updates and resources from a clean, fast authoring surface.</span>
                    </li>
                    <li className="flex gap-3">
                        <span className="mt-1 h-2.5 w-2.5 shrink-0 rounded-full bg-blue-300" />
                        <span>Students receive curated dashboards with timelines, reminders, and files ready to download.</span>
                    </li>
                </ul>
            </div>
        </div>
    </section>
);

const MetricsStrip = ({ items }) => (
    <section className="relative -mt-12 z-10">
        <div className="mx-auto max-w-5xl rounded-3xl border border-slate-200 bg-white/90 px-6 py-8 shadow-xl backdrop-blur">
            <div className="grid gap-6 text-center md:grid-cols-4">
                {items.map((metric) => (
                    <div key={metric.label} className="flex flex-col gap-1">
                        <span className="text-2xl font-semibold text-slate-900">{metric.value}</span>
                        <span className="text-xs uppercase tracking-[0.2em] text-slate-500">{metric.label}</span>
                    </div>
                ))}
            </div>
        </div>
    </section>
);

const FeatureSection = ({ features }) => (
    <section className="mx-auto max-w-6xl px-6 py-24">
        <div className="max-w-3xl">
            <p className="text-sm font-semibold uppercase tracking-[0.35em] text-slate-500">Capabilities</p>
            <h2 className="mt-3 text-3xl font-semibold text-slate-900 md:text-4xl">Everything your campus team needs in one workspace</h2>
            <p className="mt-4 text-sm leading-relaxed text-slate-600 md:text-base">
                Every module is intentionally organised so faculty and students can focus on teaching and learning rather than battling tools.
            </p>
        </div>

        <div className="mt-12 grid gap-6 md:grid-cols-2">
            {features.map((feature, index) => (
                <article
                    key={`${feature.title}-${index}`}
                    className="group relative overflow-hidden rounded-3xl border border-slate-200 bg-white p-8 shadow-sm transition hover:-translate-y-1 hover:shadow-xl"
                >
                    <span className="inline-flex h-10 w-10 items-center justify-center rounded-full bg-slate-900/5 text-sm font-semibold text-slate-700">
                        {String(index + 1).padStart(2, '0')}
                    </span>
                    <h3 className="mt-6 text-xl font-semibold text-slate-900">{feature.title}</h3>
                    <p className="mt-3 text-sm leading-relaxed text-slate-600">{feature.description}</p>
                </article>
            ))}
        </div>
    </section>
);

const WorkflowSection = ({ steps }) => (
    <section className="bg-slate-900/5 py-24">
        <div className="mx-auto max-w-6xl px-6">
            <div className="max-w-3xl">
                <p className="text-sm font-semibold uppercase tracking-[0.35em] text-slate-500">How it works</p>
                <h2 className="mt-3 text-3xl font-semibold text-slate-900 md:text-4xl">A streamlined workflow for admins, professors, and students</h2>
                <p className="mt-4 text-sm leading-relaxed text-slate-600 md:text-base">
                    Follow a simple rhythm that moves information from creation to action without losing context.
                </p>
            </div>

            <div className="mt-12 grid gap-6 md:grid-cols-2">
                {steps.map((step, index) => (
                    <div key={step.title} className="relative rounded-3xl border border-slate-200 bg-white p-8 shadow-sm">
                        <span className="inline-flex h-10 w-10 items-center justify-center rounded-full bg-slate-900 text-sm font-semibold text-white">
                            {index + 1}
                        </span>
                        <h3 className="mt-6 text-xl font-semibold text-slate-900">{step.title}</h3>
                        <p className="mt-3 text-sm leading-relaxed text-slate-600">{step.description}</p>
                    </div>
                ))}
            </div>
        </div>
    </section>
);

const AnnouncementSection = ({ announcements }) => (
    <section className="mx-auto max-w-6xl px-6 py-24">
        <div className="flex flex-col gap-6 md:flex-row md:items-end md:justify-between">
            <div>
                <p className="text-sm font-semibold uppercase tracking-[0.35em] text-slate-500">Latest announcements</p>
                <h2 className="mt-3 text-3xl font-semibold text-slate-900 md:text-4xl">Stay current with faculty updates</h2>
                <p className="mt-4 max-w-2xl text-sm leading-relaxed text-slate-600 md:text-base">
                    A curated feed keeps students informed and reduces the need for email blasts or fragmented messengers.
                </p>
            </div>
            <a
                href="/announcements"
                className="inline-flex items-center justify-center rounded-full border border-slate-300 px-5 py-2 text-sm font-semibold text-slate-700 transition hover:border-slate-900 hover:text-slate-900"
            >
                View all updates
            </a>
        </div>

        <div className="mt-10 grid gap-4">
            {announcements.length > 0 ? (
                announcements.map((announcement) => {
                    const displayDate = formatDate(announcement.publishedAt);
                    return (
                        <a
                            key={announcement.id}
                            href={announcement.url}
                            className="flex flex-col gap-2 rounded-2xl border border-slate-200 bg-white px-6 py-5 transition hover:-translate-y-1 hover:border-slate-900 hover:shadow-lg md:flex-row md:items-center md:justify-between"
                        >
                            <div>
                                <p className="text-base font-semibold text-slate-900">{announcement.title}</p>
                                {displayDate ? (
                                    <p className="mt-1 text-xs uppercase tracking-[0.25em] text-slate-500">{displayDate}</p>
                                ) : null}
                            </div>
                            <span className="text-sm font-semibold text-slate-700 md:text-right">Read announcement</span>
                        </a>
                    );
                })
            ) : (
                <div className="rounded-2xl border border-dashed border-slate-300 bg-white px-6 py-12 text-center text-sm text-slate-500">
                    Announcements will appear here as soon as professors publish their latest updates.
                </div>
            )}
        </div>
    </section>
);

const SupportStrip = ({ contactEmail }) => (
    <section className="relative isolate overflow-hidden">
        <div className="absolute inset-0 bg-gradient-to-br from-slate-900 via-slate-800 to-blue-900" />
        <div className="absolute -top-20 right-10 h-48 w-48 rounded-full bg-blue-400/40 blur-3xl" />
        <div className="relative mx-auto max-w-5xl rounded-3xl border border-white/15 bg-white/5 px-8 py-14 text-center text-white shadow-2xl backdrop-blur">
            <p className="text-sm font-semibold uppercase tracking-[0.35em] text-blue-200">Need an onboarding partner?</p>
            <h2 className="mt-4 text-3xl font-semibold tracking-tight md:text-4xl">We will help your team launch quickly</h2>
            <p className="mt-4 max-w-2xl mx-auto text-sm leading-relaxed text-blue-100 md:text-base">
                From the first professor invitation to your first wave of student announcements, we partner with you to
                guarantee a successful rollout.
            </p>
            <a
                href={`mailto:${contactEmail}`}
                className="mt-8 inline-flex items-center gap-2 rounded-full bg-white px-6 py-2.5 text-sm font-semibold text-slate-900 shadow-lg transition hover:bg-slate-100"
            >
                Email {contactEmail}
            </a>
        </div>
    </section>
);

const Footer = ({ contactEmail }) => (
    <footer className="border-t border-slate-200 bg-white">
        <div className="mx-auto flex max-w-6xl flex-col gap-8 px-6 py-10 md:flex-row md:items-center md:justify-between">
            <div>
                <p className="text-base font-semibold text-slate-900">UNI Portale</p>
                <p className="mt-1 text-sm text-slate-500">
                    Powered by Laravel, Vite, and React to deliver a crisp experience for your academic community.
                </p>
            </div>
            <div className="flex flex-wrap gap-4 text-sm text-slate-600">
                {quickLinks.map((link) => (
                    <a key={link.label} className="transition hover:text-slate-900" href={link.href}>
                        {link.label}
                    </a>
                ))}
                <a className="transition hover:text-slate-900" href={`mailto:${contactEmail}`}>
                    Support
                </a>
            </div>
        </div>
    </footer>
);

const App = ({ heroTitle, heroSubtitle, features, contactEmail, latestAnnouncements }) => {
    const safeFeatures = Array.isArray(features)
        ? features.filter((feature) => feature?.title && feature?.description)
        : defaultPage.features;
    const announcements = Array.isArray(latestAnnouncements) ? latestAnnouncements : [];

    return (
        <div className="min-h-screen bg-slate-50 text-slate-900">
            <Header />
            <main className="space-y-24 pb-24">
                <Hero title={heroTitle || defaultPage.heroTitle} subtitle={heroSubtitle || defaultPage.heroSubtitle} />
                <MetricsStrip items={metrics} />
                <FeatureSection features={safeFeatures.length > 0 ? safeFeatures : defaultPage.features} />
                <WorkflowSection steps={workflowSteps} />
                <AnnouncementSection announcements={announcements} />
                <SupportStrip contactEmail={contactEmail || defaultPage.contactEmail} />
            </main>
            <Footer contactEmail={contactEmail || defaultPage.contactEmail} />
        </div>
    );
};

const mountNode = document.getElementById('app');

if (mountNode) {
    let pageProps = defaultPage;

    if (mountNode.dataset.page) {
        try {
            const parsed = JSON.parse(mountNode.dataset.page);
            pageProps = {
                ...defaultPage,
                ...parsed,
                features: Array.isArray(parsed?.features) ? parsed.features : defaultPage.features,
                latestAnnouncements: Array.isArray(parsed?.latestAnnouncements)
                    ? parsed.latestAnnouncements
                    : defaultPage.latestAnnouncements,
            };
        } catch (error) {
            console.warn('Unable to parse homepage props:', error);
        }
    }

    createRoot(mountNode).render(<App {...pageProps} />);
}
