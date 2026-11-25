import { Head, Link, usePage } from '@inertiajs/react';
import {
    CalendarDays,
    Flag,
    Shield,
    Trophy,
    Users,
} from 'lucide-react';
import { useState } from 'react';
import { dashboard, login, register } from '@/routes';

const theme = {
    colour_background: '120b12',
    colour_dark: '8f988c',
    colour_primary: 'c8a2c8',
    colour_secondary: '372137',
    colour_text: 'f4f1ea',
    colour_text_faded: 'c5ccc0',
    colour_highlight: '5c375c',
}

const fixtures = [
    {
        group: 'Group A',
        team_a_id: 1,
        team_b_id: 2,
        team_a_score: 2,
        team_b_score: 1,
        when: 'Full time',
        live: false,
    },
    {
        group: 'Group A',
        team_a_id: 3,
        team_b_id: 4,
        team_a_score: 2,
        team_b_score: 1,
        when: 'Sat · 14:00',
        live: true,
    },
    {
        group: 'Group B',
        team_a_id: 5,
        team_b_id: 6,
        team_a_score: 2,
        team_b_score: 1,
        when: 'Sat · 16:30',
        live: false,
    },
    {
        group: 'Group B',
        team_a_id: 7,
        team_b_id: 8,
        team_a_score: 2,
        team_b_score: 1,
        when: 'Sun · 11:00',
        live: false,
    },
];

const teams = [
    {
        id: 1,
        name: 'Riverside',
    },
    {
        id: 2,
        name: 'Harbour',
    },
    {
        id: 3,
        name: 'North End',
    },
    {
        id: 4,
        name: 'Kingsway',
    },
    {
        id: 5,
        name: 'Milltown',
    },
    {
        id: 6,
        name: 'Oakfield',
    },
    {
        id: 7,
        name: 'Westgate',
    },
    {
        id: 8,
        name: 'Priory',
    },
];

const features = [
    {
        icon: Shield,
        title: 'Clubs and squads',
        copy: 'Keep every club, team, and contact in one roster instead of a stack of spreadsheets.',
    },
    {
        icon: Trophy,
        title: 'Draws that stay fair',
        copy: 'Set the format, dates, and groups, then publish a draw people can actually follow.',
    },
    {
        icon: CalendarDays,
        title: 'Fixtures with kickoff times',
        copy: 'Pair teams, lock the schedule, and move a match without rewriting the whole weekend.',
    },
    {
        icon: Flag,
        title: 'Match events as they happen',
        copy: 'Record goals, cards, and the final score so the table updates from the touchline.',
    },
];

export default function Welcome({
    canRegister = true,
}: {
    canRegister?: boolean;
}) {
    const { auth } = usePage().props;
    const [open, setOpen] = useState(false);

    const primaryHref = auth.user ? dashboard() : canRegister ? register() : login();
    const primaryLabel = auth.user
        ? 'Open dashboard'
        : canRegister
          ? 'Start a tournament'
          : 'Log in';

    return (
        <>
            <Head title="Touchline — tournament organising" />
            <div className={`min-h-screen bg-[#${theme.colour_background}] text-[#${theme.colour_text}]`}>
                <header className={`sticky top-0 z-20 border-b border-white/10 bg-[#${theme.colour_background}]/90 backdrop-blur`}>
                    <div className="mx-auto flex max-w-6xl items-center justify-between px-5 py-4">
                        <a href="#top" className="flex items-center gap-2 font-semibold tracking-tight">
                            <span className={`grid size-8 place-items-center rounded-full bg-[#${theme.colour_primary}] text-[#${theme.colour_text}]`}>
                                <Trophy className="size-4" />
                            </span>
                            Touchline
                        </a>
                        <nav className={`hidden items-center gap-8 text-sm text-[#${theme.colour_text}] md:flex`}>
                            <a href="#features" className="hover:text-white">
                                Features
                            </a>
                            <a href="#draw" className="hover:text-white">
                                The draw
                            </a>
                            <a href="#how" className="hover:text-white">
                                How it works
                            </a>
                        </nav>
                        <div className="hidden items-center gap-3 md:flex">
                            {auth.user ? (
                                <Link
                                    href={dashboard()}
                                    className={`rounded-full bg-[#${theme.colour_primary}] px-4 py-2 text-sm font-semibold text-[#${theme.colour_text}] hover:bg-[#${theme.colour_primary}]`}
                                >
                                    Dashboard
                                </Link>
                            ) : (
                                <>
                                    <Link
                                        href={login()}
                                        className={`px-3 py-2 text-sm text-[#${theme.colour_text}] hover:text-white`}
                                    >
                                        Log in
                                    </Link>
                                    {canRegister && (
                                        <Link
                                            href={register()}
                                            className={`rounded-full bg-[#${theme.colour_primary}] px-4 py-2 text-sm font-semibold text-[#${theme.colour_text}] hover:bg-[#${theme.colour_primary}]`}
                                        >
                                            Get started
                                        </Link>
                                    )}
                                </>
                            )}
                        </div>
                        <button
                            type="button"
                            className={`rounded-md border border-white/15 px-3 py-1.5 text-sm md:hidden`}
                            aria-expanded={open}
                            onClick={() => setOpen((value) => !value)}
                        >
                            Menu
                        </button>
                    </div>
                    {open && (
                        <div className={`flex flex-col gap-3 border-t border-white/10 px-5 py-4 text-sm md:hidden`}>
                            <a href="#features" onClick={() => setOpen(false)}>
                                Features
                            </a>
                            <a href="#draw" onClick={() => setOpen(false)}>
                                The draw
                            </a>
                            <a href="#how" onClick={() => setOpen(false)}>
                                How it works
                            </a>
                            {auth.user ? (
                                <Link href={dashboard()}>Dashboard</Link>
                            ) : (
                                <>
                                    <Link href={login()}>Log in</Link>
                                    {canRegister && (
                                        <Link href={register()}>Get started</Link>
                                    )}
                                </>
                            )}
                        </div>
                    )}
                </header>

                <main id="top">
                    <section className={`mx-auto grid max-w-6xl items-center gap-12 px-5 py-16 lg:grid-cols-[1.1fr_0.9fr] lg:py-24`}>
                        <div>
                            <p className={`mb-4 inline-flex items-center gap-2 rounded-full border border-[#${theme.colour_primary}]/30 bg-[#${theme.colour_primary}]/10 px-3 py-1 text-xs font-medium tracking-wide text-[#${theme.colour_primary}] uppercase`}>
                                For clubs, leagues, and one-off cups
                            </p>
                            <h1 className="max-w-xl text-4xl leading-[1.05] font-semibold tracking-tight text-balance sm:text-6xl">
                                Run the tournament from the first draw to the final whistle.
                            </h1>
                            <p className={`mt-5 max-w-lg text-lg leading-relaxed text-[#${theme.colour_text}]`}>
                                Bazinga
                            </p>
                            <div className="mt-8 flex flex-wrap items-center gap-3">
                                <Link
                                    href={primaryHref}
                                    className={`rounded-full bg-[#${theme.colour_primary}] px-5 py-3 text-sm font-semibold text-[#${theme.colour_text}] hover:bg-[#${theme.colour_primary}]`}
                                >
                                    {primaryLabel}
                                </Link>
                                <a
                                    href="#draw"
                                    className={`rounded-full border border-white/15 px-5 py-3 text-sm font-medium text-[#${theme.colour_text}] hover:border-white/40`}
                                >
                                    See a sample draw
                                </a>
                            </div>
                        </div>

                            <div className={`rounded-3xl border border-white/10 bg-[#${theme.colour_highlight}] p-5 shadow-[0_30px_80px_-40px_rgba(200,162,200,0.45)]`}>
                            <div className="mb-4 flex items-center justify-between">
                                <div>
                                    <p className={`text-xs tracking-wide text-[#${theme.colour_text}] uppercase`}>
                                        Harbour Cup
                                    </p>
                                    <p className="text-lg font-semibold">This weekend</p>
                                </div>
                                <span className={`rounded-full bg-[#${theme.colour_primary}]/15 px-3 py-1 text-xs font-medium text-[#${theme.colour_primary}]`}>
                                    8 teams
                                </span>
                            </div>
                            <ul className="space-y-2">
                                {fixtures.map((f) => {
                                    let teamA = teams.find((t) => f.team_a_id == t.id) || {id: 0, name: 'Unknown'};
                                    let teamB = teams.find((t) => f.team_b_id == t.id) || {id: 0, name: 'Unknown'};
                                    return <li
                                        key={`${teamA.name}}-${teamB.name}`}
                                        className={`grid grid-cols-[1fr_auto] items-center gap-3 rounded-2xl bg-[#${theme.colour_background}] px-4 py-3`}
                                    >
                                        <div>
                                            <p className={`text-xs text-[#${theme.colour_text}]`}>
                                                {f.group}
                                            </p>
                                            <p className="font-medium">
                                                {teamA.name}
                                                <span className={`mx-2 text-[#${theme.colour_text}]`}>
                                                    vs
                                                </span>
                                                {teamB.name}
                                            </p>
                                        </div>
                                        <div className="text-right">
                                            <p className="font-semibold tabular-nums">
                                                {f.team_a_score} - {f.team_b_score}
                                            </p>
                                            <p
                                                className={
                                                    f.live
                                                        ? 'text-xs text-[#c8a2c8]'
                                                        : 'text-xs text-[#8f988c]'
                                                }
                                            >
                                                {f.when}
                                            </p>
                                        </div>
                                    </li>
                                })}
                            </ul>
                        </div>
                    </section>

                    <section className={`border-y border-white/10 bg-[#${theme.colour_secondary}]`}>
                        <dl className="mx-auto grid max-w-6xl grid-cols-2 gap-6 px-5 py-8 sm:grid-cols-4">
                            {[
                                ['Clubs', 'One roster'],
                                ['Teams', 'Grouped by club'],
                                ['Fixtures', 'Kickoff locked'],
                                ['Events', 'Goals and cards'],
                            ].map(([label, value]) => (
                                <div key={label}>
                                    <dt className="text-sm">{label}</dt>
                                    <dd className="mt-1 text-lg font-medium">{value}</dd>
                                </div>
                            ))}
                        </dl>
                    </section>

                    <section id="features" className="mx-auto max-w-6xl px-5 py-20">
                        <div className="max-w-2xl">
                            <h2 className="text-3xl font-semibold tracking-tight sm:text-4xl">
                                Everything between the entry list and the trophy.
                            </h2>
                            <p className={`mt-3 text-[#${theme.colour_text_faded}]`}>
                                Built around the same pieces a real competition
                                already has: clubs, teams, a tournament, and the
                                games that decide it.
                            </p>
                        </div>
                        <div className="mt-10 grid gap-4 sm:grid-cols-2">
                            {features.map((feature) => {
                                const Icon = feature.icon;

                                return (
                                    <article
                                        key={feature.title}
                                        className={`rounded-3xl border border-white/10 bg-[#${theme.colour_highlight}] p-6`}
                                    >
                                        <Icon className={`size-5 text-[#${theme.colour_primary}]`} />
                                        <h3 className="mt-4 text-xl font-semibold">
                                            {feature.title}
                                        </h3>
                                        <p className="mt-2 leading-relaxed text-[#c5ccc0]">
                                            {feature.copy}
                                        </p>
                                    </article>
                                );
                            })}
                        </div>
                    </section>

                    <section id="draw" className={`bg-[#${theme.colour_secondary}] py-20`}>
                        <div className="mx-auto grid max-w-6xl items-center gap-10 px-5 lg:grid-cols-2">
                            <div>
                                <h2 className="text-3xl font-semibold tracking-tight sm:text-4xl">
                                    A draw people can read from the stand.
                                </h2>
                                <p className={`mt-3 text-[#${theme.colour_text_faded}]`}>
                                    Groups, kickoffs, and the path to the final
                                    sit on one board. Change a team and the
                                    fixture list stays in step.
                                </p>
                                <ul className={`mt-6 space-y-3 text-sm text-[#${theme.colour_text}]`}>
                                    <li className="flex gap-3">
                                        <Users className={`mt-0.5 size-4 shrink-0 text-[#${theme.colour_primary}]`} />
                                        Enter clubs once, then attach as many teams as the age groups need.
                                    </li>
                                    <li className="flex gap-3">
                                        <CalendarDays className={`mt-0.5 size-4 shrink-0 text-[#${theme.colour_primary}]`} />
                                        Set start and end dates, then fill the weekend with real kickoff times.
                                    </li>
                                </ul>
                            </div>
                            <div className={`rounded-3xl border border-white/10 bg-[#${theme.colour_highlight}] p-6`}>
                                <p className={`text-xs tracking-wide text-[#${theme.colour_text_faded}] uppercase`}>
                                    Path to the final
                                </p>
                                <div className="mt-5 grid grid-cols-[1fr_auto_1fr] items-center gap-3 text-sm">
                                    <div className="space-y-3">
                                        <FixturePill home="Riverside" away="Kingsway" />
                                        <FixturePill home="Milltown" away="Priory" />
                                    </div>
                                    <div className={`h-24 w-px bg-[#${theme.colour_highlight}]/40`} />
                                    <div className={`rounded-2xl bg-[#${theme.colour_highlight}] px-4 py-5 text-center font-semibold text-[#${theme.colour_text}]`}>
                                        Final
                                        <p className={`mt-1 text-xs font-medium text-[#${theme.colour_text_faded}]`}>
                                            Sun · 15:00
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </section>

                    <section id="how" className="mx-auto max-w-6xl px-5 py-20">
                        <h2 className="text-3xl font-semibold tracking-tight sm:text-4xl">
                            Three steps, then you are on the pitch.
                        </h2>
                        <ol className="mt-10 grid gap-6 md:grid-cols-3">
                            {[
                                ['01', 'Open the competition', 'Name the tournament, pick the dates, and choose the format.'],
                                ['02', 'Add the sides', 'Bring in clubs and the teams that will actually play.'],
                                ['03', 'Publish the draw', 'Share fixtures, then record the result as each game finishes.'],
                            ].map(([step, title, copy]) => (
                                <li key={step} className="border-t border-[#c8a2c8]/40 pt-4">
                                    <p className={`text-sm font-medium text-[#${theme.colour_primary}]`}>{step}</p>
                                    <h3 className="mt-2 text-xl font-semibold">{title}</h3>
                                    <p className={`mt-2 text-[#${theme.colour_text_faded}]`}>{copy}</p>
                                </li>
                            ))}
                        </ol>
                    </section>

                    <section className="px-5 pb-20">
                        <div className={`mx-auto flex max-w-6xl flex-col items-start justify-between gap-6 rounded-3xl bg-[#${theme.colour_primary}] px-8 py-10 text-[#${theme.colour_text}] sm:flex-row sm:items-center`}>
                            <div>
                                <h2 className="text-3xl font-semibold tracking-tight">
                                    Put the next cup on the board.
                                </h2>
                                <p className={`mt-2 max-w-xl text-[#${theme.colour_secondary}]`}>
                                    Create the tournament, invite the clubs, and
                                    stop passing the spreadsheet around the group chat.
                                </p>
                            </div>
                            <Link
                                href={primaryHref}
                                className={`shrink-0 rounded-full bg-[#${theme.colour_background}] px-5 py-3 text-sm font-semibold text-[#${theme.colour_text}] hover:bg-black`}
                            >
                                {primaryLabel}
                            </Link>
                        </div>
                    </section>
                </main>

                <footer className="border-t border-white/10">
                    <div className={`mx-auto flex max-w-6xl flex-col gap-2 px-5 py-8 text-sm text-[#${theme.colour_text_faded}] sm:flex-row sm:items-center sm:justify-between`}>
                        <p>Touchline · tournament organising</p>
                        <p>Clubs, teams, fixtures, and the final whistle.</p>
                    </div>
                </footer>
            </div>
        </>
    );
}

function FixturePill({ home, away }: { home: string; away: string }) {
    return (
        <div className={`rounded-2xl bg-[#${theme.colour_background}] px-4 py-3`}>
            <p>{home}</p>
            <p className={`text-[#${theme.colour_text_faded}]`}>{away}</p>
        </div>
    );
}
