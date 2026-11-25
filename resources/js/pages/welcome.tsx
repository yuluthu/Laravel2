import { Head, Link, usePage } from '@inertiajs/react';
import {
    CalendarDays,
    Flag,
    Shield,
    Trophy,
    Users,
    RefreshCw
} from 'lucide-react';
import {
    createContext,
    useCallback,
    useContext,
    useEffect,
    useState,
    type CSSProperties,
} from 'react';
import Query from '@/api/Query';
import { dashboard, login, register } from '@/routes';
import Dashboard from './dashboard';

const theme = {
    colour_background: '120b12',
    colour_dark: '8f988c',
    colour_primary: 'c8a2c8',
    colour_secondary: '372137',
    colour_text: 'f4f1ea',
    colour_text_faded: 'c5ccc0',
    colour_highlight: '5c375c',
}

type BoardTeam = {
    id: number;
    name: string;
};

type BoardFixture = {
    group: string;
    team_a_id: number;
    team_b_id: number;
    team_a_score: number | null;
    team_b_score: number | null;
    when: string;
    live: boolean;
};

type Board = {
    tournament: string;
    polled_at: string;
    source: string;
    teams: BoardTeam[];
    fixtures: BoardFixture[];
};

const themeStyle = {
    '--tl-bg': `#${theme.colour_background}`,
    '--tl-dark': `#${theme.colour_dark}`,
    '--tl-primary': `#${theme.colour_primary}`,
    '--tl-secondary': `#${theme.colour_secondary}`,
    '--tl-text': `#${theme.colour_text}`,
    '--tl-faded': `#${theme.colour_text_faded}`,
    '--tl-highlight': `#${theme.colour_highlight}`,
} as CSSProperties;

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

const TeamsContext = createContext<BoardTeam[]>([]);

function useTeams(): BoardTeam[] {
    return useContext(TeamsContext);
}

export default function Welcome({
    canRegister = true,
    board,
}: {
    canRegister?: boolean;
    board: Board;
}) {
    const { auth } = usePage().props;
    const [open, setOpen] = useState(false);
    const { board: liveBoard, teams, status, refresh } = useBoardPoll(board);

    const primaryHref = auth.user ? dashboard() : canRegister ? register() : login();
    return (
        <TeamsContext.Provider value={teams}>
            <Head title="QuadTrack" />
            <div
                className="min-h-screen bg-[var(--tl-bg)] text-[var(--tl-text)]"
                style={themeStyle}
            >
                <header className={`sticky top-0 z-20 border-b border-white/10 bg-[color-mix(in_srgb,var(--tl-bg)_90%,transparent)] backdrop-blur`}>
                    <div className="mx-auto flex max-w-6xl items-center justify-between px-5 py-4">
                        <a href="#top" className="flex items-center gap-2 font-semibold tracking-tight">
                            <span className={`grid size-8 place-items-center rounded-full bg-[var(--tl-primary)] text-[var(--tl-text)]`}>
                                <Trophy className="size-4" />
                            </span>
                            QuadTrack
                        </a>
                        <nav className={`hidden items-center gap-8 text-sm text-[var(--tl-text)] md:flex`}>
                            <a href="#features" className="hover:text-white">
                                Tournaments
                            </a>
                            <a href="#draw" className="hover:text-white">
                                Clubs
                            </a>
                            <a href="#how" className="hover:text-white">
                                Teams
                            </a>
                        </nav>
                        <div className="hidden items-center gap-3 md:flex">
                            {auth.user ? (
                                <Link
                                    href={dashboard()}
                                    className={`rounded-full bg-[var(--tl-primary)] px-4 py-2 text-sm font-semibold text-[var(--tl-text)] hover:bg-[var(--tl-primary)]`}
                                >
                                    Dashboard
                                </Link>
                            ) : (
                                <>
                                    <Link
                                        href={register()}
                                        className={`px-3 py-2 text-sm text-[var(--tl-text)] hover:text-white`}
                                    >
                                        Register
                                    </Link>
                                    <Link
                                        href={login()}
                                        className={`rounded-full bg-[var(--tl-primary)] px-4 py-2 text-sm font-semibold text-[var(--tl-text)] hover:bg-[var(--tl-primary)]`}
                                    >
                                        Login
                                    </Link>
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
                            <p className={`mb-4 inline-flex items-center gap-2 rounded-full border border-[color-mix(in_srgb,var(--tl-primary)_30%,transparent)] bg-[color-mix(in_srgb,var(--tl-primary)_10%,transparent)] px-3 py-1 text-xs font-medium tracking-wide text-[var(--tl-primary)] uppercase`}>
                                For clubs, leagues, and one-off cups
                            </p>
                            <h1 className="max-w-xl text-4xl leading-[1.05] font-semibold tracking-tight text-balance sm:text-6xl">
                                QuadTrack
                            </h1>
                            <p className={`mt-5 max-w-lg text-lg leading-relaxed text-[var(--tl-text)]`}>
                                Bazinga
                            </p>
                            <div className="mt-8 flex flex-wrap items-center gap-3">
                                <Link
                                    href={login()}
                                    className={`rounded-full bg-[var(--tl-primary)] px-5 py-3 text-sm font-semibold text-[var(--tl-text)] hover:bg-[var(--tl-primary)]`}
                                >
                                    View Tournaments
                                </Link>
                                <a
                                    href="#draw"
                                    className={`rounded-full border border-white/15 px-5 py-3 text-sm font-medium text-[var(--tl-text)] hover:border-white/40`}
                                >
                                    See a sample draw
                                </a>
                            </div>
                        </div>

                            <div className="rounded-3xl border border-white/10 bg-[var(--tl-highlight)] p-5 shadow-[0_30px_80px_-40px_rgba(200,162,200,0.45)]">
                            <div className="mb-4 flex items-center justify-between gap-3">
                                <div>
                                    <p className="text-xs tracking-wide text-[var(--tl-text)]">
                                    Latest Tournament:
                                    </p>
                                    <p className="text-lg font-semibold">{liveBoard.tournament}</p>
                                </div>
                                <div>
                                    <span className="rounded-full bg-[color-mix(in_srgb,var(--tl-primary)_15%,transparent)] align-sub  p-2 text-xs font-medium text-[var(--tl-primary)]">
                                        {status === 'error'
                                            ? 'Offline'
                                            : `Updated ${formatPolledAt(liveBoard.polled_at)}`}
                                    </span>
                                    <button
                                        type="button"
                                        className="rounded-full bg-[color-mix(in_srgb,var(--tl-primary)_15%,transparent)] align-top ml-2 mr-1 p-2 text-[var(--tl-primary)]"
                                        aria-label="Refresh the board"
                                        onClick={() => void refresh()}
                                        >
                                        <RefreshCw className="text-sm size-4" />
                                    </button>
                                </div>
                            </div>
                            <ul className="space-y-2">
                                {liveBoard.fixtures.map((fixture) => {
                                    return (
                                    <li
                                        key={`${fixture.team_a_id}-${fixture.team_b_id}-${fixture.when}`}
                                        className="grid grid-cols-[1fr_auto] items-center gap-3 rounded-2xl bg-[var(--tl-bg)] px-4 py-3"
                                    >
                                        <div>
                                            <p className="text-xs text-[var(--tl-text)]">
                                                {fixture.group}
                                            </p>
                                            <p className="font-medium">
                                                <TeamName id={fixture.team_a_id} />
                                                <span className="mx-2 text-[var(--tl-text)]">
                                                    vs
                                                </span>
                                                <TeamName id={fixture.team_b_id} />
                                            </p>
                                        </div>
                                        <div className="text-right">
                                            <p className="font-semibold tabular-nums">
                                                {scoreLabel(fixture)}
                                            </p>
                                            <p
                                                className={
                                                    fixture.live
                                                        ? 'text-xs text-[var(--tl-primary)]'
                                                        : 'text-xs text-[var(--tl-dark)]'
                                                }
                                            >
                                                {fixture.when}
                                            </p>
                                        </div>
                                    </li>
                                    );
                                })}
                            </ul>
                        </div>
                    </section>

                </main>

                <footer className="border-t border-white/10">
                    <div className={`mx-auto flex max-w-6xl flex-col gap-2 px-5 py-8 text-sm text-[var(--tl-faded)] sm:flex-row sm:items-center sm:justify-between`}>
                        <p>QuadTrack</p>
                        <p>Clubs, teams, fixtures.</p>
                    </div>
                </footer>
            </div>
        </TeamsContext.Provider>
    );
}

function useBoardPoll(initial: Board): {
    board: Board;
    teams: BoardTeam[];
    status: 'live' | 'error';
    refresh: () => Promise<void>;
} {
    const [board, setBoard] = useState(initial);
    const [teams, setTeams] = useState<BoardTeam[]>(initial.teams);
    const [status, setStatus] = useState<'live' | 'error'>('live');

    const refresh = useCallback(async () => {
        try {
            const next = await Query('board');

            setBoard(next);
            setTeams(next.teams);
            setStatus('live');
        } catch {
            setStatus('error');
        }
    }, []);

    useEffect(() => {
        void refresh();
    }, [refresh]);

    return { board, teams, status, refresh };
}

function TeamName({ id }: { id: number }) {
    const teams = useTeams();

    return teams.find((team) => team.id === id)?.name ?? 'Unknown';
}

function scoreLabel(fixture: BoardFixture): string {
    if (fixture.team_a_score === null || fixture.team_b_score === null) {
        return '—';
    }

    return `${fixture.team_a_score}–${fixture.team_b_score}`;
}

function formatPolledAt(value: string): string {
    const date = new Date(value);

    if (Number.isNaN(date.getTime())) {
        return 'just now';
    }

    return date.toLocaleTimeString([], {
        hour: '2-digit',
        minute: '2-digit',
        second: '2-digit',
    });
}

function FixturePill({ home, away }: { home: string; away: string }) {
    return (
        <div className={`rounded-2xl bg-[var(--tl-bg)] px-4 py-3`}>
            <p>{home}</p>
            <p className={`text-[var(--tl-faded)]`}>{away}</p>
        </div>
    );
}
