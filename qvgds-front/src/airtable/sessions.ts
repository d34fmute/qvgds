import type { TSession } from '@/types/TSession';
import { base } from './airtable.instance';

export const sessionsTable = base.table<TSession>('sessions');

export const getSessions = async () => {
  return await sessionsTable.select().all();
};