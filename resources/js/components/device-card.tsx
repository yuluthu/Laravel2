import { cn } from '@/lib/utils';
import { AlertTriangle, Battery, Check, Cpu, Satellite } from 'lucide-react';

export type DeviceCardProps = {
  device: object
};

export default function DeviceCard({
  device
}: DeviceCardProps) {
  const showAlertIcon = device.current_status.batteryCharge < 20 || device.current_status.sensorLife < 20 ;
  const indicatorColor = showAlertIcon ? 'text-rose-400' : 'text-emerald-400';
  const borderClass = showAlertIcon ? 'border-t-4 border-rose-500' : '';
  const actionButtonClass = 'inline-flex items-center justify-center border rounded-md bg-[#153ce4] px-4 py-2 text-sm font-medium text-white transition hover:bg-[#1b4de6] focus:outline-none focus:ring-2 focus:ring-[#4e7cff]/50 cursor-default opacity-80'

  const connectionStatus = (lastUpdate:Date) => {
    const now = new Date();
      if (now.valueOf() - lastUpdate.valueOf() > (24 * 60 * 60 * 1000)) {
        return 'text-rose-400';
      }
      return 'text-emerald-400';
  }

  const getIndicatorColor = (value: number) => {
    if (value >= 20) return 'text-emerald-400';
    return 'text-rose-400';
  }

  return (
    <div
      className={cn(
        'max-w-lg flex flex-col overflow-hidden rounded-[18px] border border-slate-800 bg-[#20203b] shadow-[0_20px_80px_rgba(0,0,0,0.20)]',
        borderClass,
      )}
    >
      <div className="space-y-6 p-5">
        <div className="flex flex-col gap-4 sm:items-end sm:justify-between sm:flex-row">
          <div className="flex min-w-0 items-start gap-3">
            {showAlertIcon ? (
              <div className="flex h-10 w-10 items-center justify-center rounded-2xl bg-rose-500/15 text-rose-300">
                <AlertTriangle size={20} />
              </div>
            ) : null}

            <div className="min-w-0">
              <p className="truncate text-base font-semibold text-white">{device.location.name}</p>
              <p className="mt-1 truncate text-sm text-slate-400">{device.product.name}</p>
            </div>
          </div>

          <div className="flex items-center gap-3 text-slate-300">
            <div className={cn('inline-flex h-10 w-10 items-center justify-center rounded-2xl bg-slate-900', getIndicatorColor(device.current_status.battery_charge))}>
              <Battery size={18} />
            </div>
            <div className={cn('inline-flex h-10 w-10 items-center justify-center rounded-2xl bg-slate-900', getIndicatorColor(device.current_status.sensor_life))}>
              <Cpu size={18} />
            </div>
            <div className={cn('inline-flex h-10 w-10 items-center justify-center rounded-2xl bg-slate-900', connectionStatus(device.current_status.updated_at))}>
              <Satellite size={18} />
            </div>
          </div>
        </div>

        <div className="grid gap-4 sm:grid-cols-2">
          <div className="space-y-3">
            <div className="flex items-end justify-between gap-3 text-sm text-white">
              <span className="font-semibold">Battery charge</span>
              <span className="font-medium text-slate-200">{device.current_status.battery_charge}%</span>
            </div>
            <div className="h-2 overflow-hidden rounded-full bg-slate-950">
              <div
                className="h-full rounded-full bg-rose-500"
                style={{ width: `${device.current_status.battery_charge}%` }}
              />
            </div>
          </div>

          <div className="space-y-3">
            <div className="flex items-end justify-between gap-3 text-sm text-white">
              <span className="font-semibold">Sensor pack</span>
              <span className="font-medium text-slate-200">{device.current_status.sensor_life} days</span>
            </div>
            <div className="h-2 overflow-hidden rounded-full bg-slate-950">
              <div
                className="h-full rounded-full bg-rose-500"
                style={{ width: `${device.current_status.sensor_life}%` }}
              />
            </div>
          </div>
        </div>
      </div>

      <div className="space-y-4 bg-[#2b2b4e] px-5 py-4">
        <div className="flex items-center justify-between gap-3">
          <p className="text-sm font-semibold text-white">SondeCare+</p>
          <span
            className={cn(
              'inline-flex items-center gap-2 rounded-md border px-3 py-1 text-sm font-medium',
              device.subscription ? 'border-emerald-500 text-emerald-200' : 'border-slate-600 text-slate-200'
            )}
          >
            {device.subscription ? <Check size={14} /> : null}
            {device.subscription ? 'Subscribed' : 'Not subscribed'}
          </span>
        </div>

        <div className="flex items-center justify-between gap-3">
          <p className="text-sm font-semibold text-white">Replacement Status</p>
          <div className="inline-flex items-center gap-2 rounded-md px-3 py-1 text-sm font-medium">
            {
              device.order ? (
                device.order.delivery_date ? (
                  <p className="mt-1 text-sm text-slate-100 underline">Delivered on {new Date(device.order.delivery_date).toLocaleDateString()}</p>
                ) : (
                  <p className="mt-1 text-sm text-slate-400">Order placed</p>
                )
              ) : (
                <button type="button" className={actionButtonClass}>
                  Order now
                </button>
              )
            }
          </div>
        </div>
      </div>
    </div>
  );
}
